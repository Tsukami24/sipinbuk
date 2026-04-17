<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookItem;
use App\Models\Borrow;
use App\Models\BorrowDetail;
use App\Models\DamagedBook;
use App\Models\Fine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BorrowController extends Controller
{
    // ADMIN - LIST BORROW
    public function index()
    {
        $borrows = Borrow::with([
            'user',
            'details.bookItem.book'
        ])->latest()->get();

        return view('admin.borrows.index', compact('borrows'));
    }

    // ADMIN - DETAIL BORROW
    public function show(Borrow $borrow)
    {
        $borrow->load([
            'user',
            'details.bookItem.book',
            'details.fines'
        ]);

        return view('admin.borrows.show', compact('borrow'));
    }

    // USER - HISTORY
    public function history()
    {
        $borrows = Borrow::with('details.bookItem.book')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.borrows.history', compact('borrows'));
    }

    // USER - HISTORY DETAIL
    public function historyShow(Borrow $borrow)
    {
        abort_if($borrow->user_id !== Auth::id(), 403);

        $borrow->load([
            'details.bookItem.book',
            'details.fines'
        ]);

        return view('user.borrows.show', compact('borrow'));
    }

    // USER - CREATE BORROW
    public function create()
    {
        $books = Book::whereHas('Items', function ($query) {
            $query->where('status', 'available');
        })->get();

        return view('user.borrows.create', compact('books'));
    }

    // USER - STORE BORROW
    public function store(Request $request)
    {
        $request->validate([
            'borrow_date' => 'required|date',
            'due_date'    => 'required|date|after_or_equal:borrow_date',
            'book_ids'    => 'required|array|min:1',
            'book_ids.*'  => 'exists:books,id',
            'quantity'    => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $borrowDate = Carbon::parse($request->borrow_date);
            $dueDate    = Carbon::parse($request->due_date);

            $borrow = Borrow::create([
                'user_id'     => Auth::id(),
                'borrow_date' => $borrowDate,
                'due_date'    => $dueDate,
                'status'      => 'pending',
            ]);

            foreach ($request->book_ids as $bookId) {
                $quantity = $request->quantity;

                $availableItems = BookItem::where('book_id', $bookId)
                    ->where('status', 'available')
                    ->limit($quantity)
                    ->lockForUpdate()
                    ->get();

                if ($availableItems->count() < $quantity) {
                    throw new \Exception("Buku dengan ID {$bookId} tidak cukup tersedia.");
                }

                foreach ($availableItems as $item) {
                    BorrowDetail::create([
                        'borrow_id'    => $borrow->id,
                        'book_item_id' => $item->id,
                    ]);
                }
            }
        });

        return redirect()->route('borrows.history')
            ->with('success', 'Peminjaman berhasil diajukan');
    }

    // ADMIN - APPROVE BORROW
    public function approve(Borrow $borrow)
    {
        DB::transaction(function () use ($borrow) {

            foreach ($borrow->details as $detail) {
                $item = $detail->bookItem;

                if ($item->status !== 'available') {
                    throw new \Exception('Buku tidak tersedia');
                }

                $item->update(['status' => 'borrowed']);
            }

            $borrow->update([
                'status' => 'active'
            ]);
        });

        return back()->with('success', 'Peminjaman disetujui');
    }

    // ADMIN - REJECT BORROW
    public function reject(Borrow $borrow)
    {
        $borrow->update([
            'status' => 'rejected'
        ]);

        return back()->with('success', 'Peminjaman ditolak');
    }

    // ADMIN - UPDATE DUE DATE
    public function updateDueDate(Request $request, Borrow $borrow)
    {
        if ($borrow->status !== 'pending') {
            return back()->with('error', 'Due date hanya bisa diubah saat menunggu persetujuan');
        }

        $request->validate([
            'due_date' => 'required|date|after_or_equal:' . $borrow->borrow_date,
        ]);

        $borrow->update([
            'due_date' => $request->due_date
        ]);

        return back()->with('success', 'Due date berhasil diubah');
    }

    // USER - AJUKAN PENGEMBALIAN
    public function requestReturn($detailId)
    {
        $detail = BorrowDetail::findOrFail($detailId);

        if ($detail->borrow->user_id !== Auth::id()) {
            abort(403);
        }

        if ($detail->return_requested || $detail->returned_at) {
            return back()->with('error', 'Pengembalian sudah diajukan.');
        }

        $detail->update([
            'return_requested' => true
        ]);

        return back()->with('success', 'Pengembalian berhasil diajukan');
    }

    // ADMIN - PROSES RETURN
    public function processReturn(Request $request, Borrow $borrow)
    {

        if ($request->has('condition') && !$request->has('details')) {
            $request->merge([
                'details' => [
                    [
                        'id' => $request->route('detail') ?? null,
                        'condition' => $request->condition,
                    ]
                ]
            ]);
        }

        $request->validate([
            'details' => 'required|array|min:1',
            'details.*.id' => 'required|exists:borrow_details,id',
            'details.*.condition' => 'required|in:good,damaged,lost',
        ]);

        DB::transaction(function () use ($request, $borrow) {

            $today = Carbon::today();
            $dueDate = Carbon::parse($borrow->due_date);
            $lateDays = $today->gt($dueDate) ? $today->diffInDays($dueDate) : 0;

            foreach ($request->details as $itemData) {
                $detail = $borrow->details()->findOrFail($itemData['id']);
                if (!$detail->return_requested) continue;
                $bookItem = $detail->bookItem;

                if ($detail->returned_at) continue;

                $detail->update([
                    'returned_at' => $today,
                    'return_condition' => $itemData['condition'],
                ]);

                switch ($itemData['condition']) {
                    case 'good':
                        $bookItem->update(['status' => 'available']);
                        break;
                    case 'damaged':
                        $bookItem->update(['status' => 'damaged']);

                        DamagedBook::create([
                            'borrow_detail_id' => $detail->id,
                            'book_item_id' => $bookItem->id,
                            'damage_level' => 'medium', 
                            'description' => 'Buku rusak saat pengembalian',
                        ]);

                        Fine::create([
                            'borrow_id' => $borrow->id,
                            'borrow_detail_id' => $detail->id,
                            'fine_type' => 'damage',
                            'amount' => 20000,
                            'note' => 'Buku rusak',
                        ]);
                        break;
                    case 'lost':
                        $bookItem->update(['status' => 'lost']);
                        Fine::create([
                            'borrow_id' => $borrow->id,
                            'borrow_detail_id' => $detail->id,
                            'fine_type' => 'lost',
                            'amount' => 100000,
                            'note' => 'Buku hilang',
                        ]);
                        break;
                }

                if ($lateDays > 0) {
                    Fine::create([
                        'borrow_id' => $borrow->id,
                        'borrow_detail_id' => $detail->id,
                        'fine_type' => 'late',
                        'amount' => $lateDays * 5000,
                        'note' => "Terlambat {$lateDays} hari",
                    ]);
                }
            }

            $hasUnreturned = $borrow->details()->whereNull('returned_at')->exists();

            if ($hasUnreturned) {
                $borrow->status = now()->gt($borrow->due_date) ? 'overdue' : 'active';
            } else {
                $borrow->status = 'completed';
            }

            $borrow->save();
        });

        return back()->with('success', 'Pengembalian berhasil diproses');
    }

    public function pay(Fine $fine)
    {
        $fine->update(['is_paid' => true]);

        return back()->with('success', 'Denda ditandai lunas');
    }
}
