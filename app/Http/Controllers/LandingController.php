<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function landing()
    {
        $books = Book::latest()->take(6)->get();

        return view('user.landing', compact('books'));
    }
}
