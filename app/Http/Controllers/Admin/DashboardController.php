<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookItem;
use App\Models\Borrow;
use App\Models\DamagedBook;

class DashboardController extends Controller
{
    public function index()
    {
        // Total buku (semua item)
        $totalBooks = BookItem::count();

        // $totalBooks = BookItem::where('status', 'available')->count();

        // Peminjaman yang sedang berlangsung
        $activeLoans = Borrow::where('status', 'active')->count();

        // Buku rusak
        $damagedBooks = BookItem::where('status', 'damaged')->count();

        return view('admin.dashboard', compact(
            'totalBooks',
            'activeLoans',
            'damagedBooks'
        ));
    }
}
