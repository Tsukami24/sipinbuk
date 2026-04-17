<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookItem;
use App\Models\DamagedBook;
use Illuminate\Http\Request;

class DamagedbookController extends Controller
{
    // List Damaged Books
    public function index()
    {
        $damagedBooks = DamagedBook::with([
            'bookItem.book',
            'borrowDetail.borrow.user'
        ])->latest()->get();

        return view('admin.damaged_books.index', compact('damagedBooks'));
    }

    // Show Detail Damaged Book
    public function show(DamagedBook $damagedBook)
    {
        $damagedBook->load([
            'bookItem.book',
            'borrowDetail.borrow.user'
        ]);

        return view('admin.damaged_books.show', compact('damagedBook'));
    }

    // Show Create Damaged Book Form
    public function create()
    {
        $bookItems = BookItem::where('status', 'available')->get();

        return view('admin.damaged_books.create', compact('bookItems'));
    }

    // Store New Damaged Book
    public function store(Request $request)
    {
        $request->validate([
            'book_item_id' => 'required|exists:book_items,id',
            'damage_level' => 'required|in:light,medium,heavy',
            'description'  => 'nullable|string'
        ]);

        $bookItem = BookItem::findOrFail($request->book_item_id);

        // update status buku jadi damaged
        $bookItem->update(['status' => 'damaged']);

        DamagedBook::create([
            'book_item_id' => $bookItem->id,
            'borrow_detail_id' => null,
            'damage_level' => $request->damage_level,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.damaged-books.index')
            ->with('success', 'Buku rusak berhasil ditambahkan');
    }

    // Delete Damaged Book & Mark as Available
    public function destroy(DamagedBook $damagedBook)
    {
        $bookItem = $damagedBook->bookItem;

        // hapus data buku rusak
        $damagedBook->delete();

        // balikin status buku jadi available
        $bookItem->update([
            'status' => 'available'
        ]);

        return back()->with('success', 'Buku berhasil diperbaiki & tersedia kembali');
    }

}
