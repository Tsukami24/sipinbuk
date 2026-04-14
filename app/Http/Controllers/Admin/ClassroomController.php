<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classroom;

class ClassroomController extends Controller
{
    // List Classrooms
    public function index()
    {
        $classrooms = Classroom::all();
        return view('admin.classrooms.index', compact('classrooms'));
    }

    // Show Create Classroom Form
    public function create()
    {
        return view('admin.classrooms.create');
    }

    // Create New Classroom
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:classrooms,name',
            'major' => 'required',
        ]);

        Classroom::create($request->only('name', 'major'));

        return redirect()->route('admin.classrooms.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    // Show Edit Classroom Form
    public function edit(Classroom $classroom)
    {
        return view('admin.classrooms.edit', compact('classroom'));
    }

    // Update Classroom
    public function update(Request $request, Classroom $classroom)
    {
        $request->validate([
            'name' => 'required|unique:classrooms,name,' . $classroom->id,
            'major' => 'required',
        ]);

        $classroom->update($request->only('name', 'major'));

        return redirect()->route('admin.classrooms.index')->with('success', 'Kelas berhasil diperbarui');
    }

    // Delete Classroom
    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return redirect()->route('admin.classrooms.index')->with('success', 'Kelas berhasil dihapus');
    }
}
