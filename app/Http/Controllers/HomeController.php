<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Category;
use App\Models\Fine;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $query = Book::with(['category', 'subcategory']);

        // SEARCH
        if ($request->filled('search')) {
            $search = trim($request->search);

            $keywords = explode(' ', $search);

            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->where(function ($sub) use ($word) {
                        $sub->where('title', 'like', "%{$word}%")
                            ->orWhere('author', 'like', "%{$word}%")
                            ->orWhere('publisher', 'like', "%{$word}%");
                    });
                }
            });
        }

        // FILTER CATEGORY
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // FILTER SUBCATEGORY
        if ($request->filled('subcategory')) {
            $query->where('subcategory_id', $request->subcategory);
        }

        $books = $query->latest()->paginate(12)->withQueryString();

        // DATA FILTER
        $categories = Category::all();

        $subcategories = [];
        if ($request->filled('category')) {
            $subcategories = Subcategory::where('category_id', $request->category)->get();
        }

        // STATISTIK
        $totalFine = Fine::where('is_paid', false)
            ->whereHas('borrowDetail.borrow', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->sum('amount');

        return view('user.home', compact(
            'books',
            'categories',
            'subcategories',
            'totalFine'
        ) + [
            'totalBorrow' => Borrow::where('user_id', $userId)->count(),
            'activeBorrow' => Borrow::where('user_id', $userId)
                ->where('status', 'active')
                ->count(),
        ]);
    }
}
