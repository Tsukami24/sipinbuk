<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\BookItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookItemController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'book_code' => 'required|unique:book_items,book_code',
            'status' => 'required'
        ]);

        $book->items()->create([
            'book_code' => $request->book_code,
            'status' => $request->status
        ]);

        return back()->with('success', 'Unit buku ditambahkan');
    }

    public function update(Request $request, Book $book, BookItem $item)
    {
        $item->update([
            'book_code' => $request->book_code,
            'status' => $request->status
        ]);

        return back()->with('success', 'Unit buku diperbarui');
    }

    public function destroy(Book $book, BookItem $item)
    {
        $item->delete();
        return back()->with('success', 'Unit buku dihapus');
    }
}
