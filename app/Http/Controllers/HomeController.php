<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Fine;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $totalFine = Fine::where('is_paid', false)
            ->whereHas('borrowDetail.borrow', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->sum('amount');

        return view('user.home', [
            'totalBorrow' => Borrow::where('user_id', $userId)->count(),

            'activeBorrow' => Borrow::where('user_id', $userId)
                ->where('status', 'active')
                ->count(),

            'totalFine' => $totalFine,

            'books' => Book::latest()->take(4)->get(),
        ]);
    }
}
