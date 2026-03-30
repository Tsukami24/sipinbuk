<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubcategoryController extends Controller
{
    // List Subcategories
    public function index()
    {
        $subcategories = Subcategory::with('category')->latest()->get();
        return view('admin.subcategories.index', compact('subcategories'));
    }

    // Show Create Subcategory Form
    public function create()
    {
        $categories = Category::all();
        return view('admin.subcategories.create', compact('categories'));
    }

    // Create New Subcategory
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        Subcategory::create($request->all());

        return redirect()->route('admin.subcategories.index')->with('success', 'Subkategori berhasil ditambahkan');
    }

    // Show Edit Subcategory Form
    public function edit(Subcategory $subcategory)
    {
        $categories = Category::all();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    // Update Subcategory
    public function update(Request $request, Subcategory $subcategory)
    {
    $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $subcategory->update($request->all());

        return redirect()->route('admin.subcategories.index')->with('success', 'Subkategori berhasil diperbarui');
    }

    // Delete Subcategory
    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
        return redirect()->route('admin.subcategories.index')->with('success', 'Subkategori berhasil dihapus');
    }
}
