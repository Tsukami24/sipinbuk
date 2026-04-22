<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookItem;
use App\Models\Borrow;
use App\Models\BorrowDetail;

class DashboardController extends Controller
{
    public function index()
    {
        // Total buku (semua item)
        $totalBooks = BookItem::count();

        // Peminjaman aktif
        $activeLoans = Borrow::where('status', 'active')->count();

        // Buku rusak
        $damagedBooks = BookItem::where('status', 'damaged')->count();

        // LOG AKTIVITAS
        $logs = collect()
            ->merge(
                Borrow::latest()
                    ->take(2)
                    ->get()
                    ->map(function ($item) {
                        return (object)[
                            'waktu_log' => $item->created_at->format('Y-m-d'),
                            'action' => 'Peminjaman Buku',
                            'reason' => ($item->user->name ?? '-') . ' melakukan peminjaman',
                        ];
                    })
            )
            ->merge(
                BorrowDetail::latest()
                    ->take(1)
                    ->get()
                    ->map(function ($item) {
                        return (object)[
                            'waktu_log' => $item->created_at->format('Y-m-d'),
                            'action' => 'Detail Peminjaman',
                            'reason' => 'Buku: ' . ($item->bookItem->book->title ?? '-'),
                        ];
                    })
            )
            ->sortByDesc('waktu_log')
            ->take(3);

        return view('admin.dashboard', compact(
            'totalBooks',
            'activeLoans',
            'damagedBooks',
            'logs'
        ));
    }
}
