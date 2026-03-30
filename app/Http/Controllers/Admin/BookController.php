<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\BookItem;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['category', 'subcategory', 'items'])->get();
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        return view('admin.books.create', [
            'categories' => Category::all(),
            'subcategories' => Subcategory::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'year' => 'required|digits:4',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:5000'
        ]);


        // upload cover
        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')
                ->store('covers', 'public');
        }

        Book::create($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil ditambahkan');
    }

    public function show(Book $book)
    {
        $book->load('items');
        $statuses = BookItem::statuses();
        return view('admin.books.show', compact('book', 'statuses'));
    }

    public function edit(Book $book)
    {
        return view('admin.books.edit', [
            'book' => $book,
            'categories' => Category::all(),
            'subcategories' => Subcategory::all()
        ]);
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'year' => 'required|digits:4',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:5000'
        ]);


        // ganti cover lama
        if ($request->hasFile('cover')) {
            if ($book->cover) {
                Storage::disk('public')->delete($book->cover);
            }

            $validated['cover'] = $request->file('cover')
                ->store('covers', 'public');
        }

        $book->update($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil diupdate');
    }

    public function destroy(Book $book)
    {
        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }

        $book->delete();

        return back()->with('success', 'Buku dihapus');
    }
}
