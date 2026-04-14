<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // List Users
    public function index()
    {
        $users = User::with('classroom')
            ->where('role', 'user')
            ->get();

        return view('admin.users.index', compact('users'));
    }

    // Show Create User Form
    public function create()
    {
        $classrooms = Classroom::all();
        return view('admin.users.create', compact('classrooms'));
    }

    // Create New User
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|string|max:20|unique:users,nis',
            'password' => 'required|min:8',
            'classroom_id' => 'nullable|exists:classrooms,id',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'user';

        User::create($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    // Show Edit Form
    public function edit(User $user)
    {
        $classrooms = Classroom::all();
        return view('admin.users.edit', compact('user', 'classrooms'));
    }

    // Update User
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'nis' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|min:8',
            'classroom_id' => 'nullable|exists:classrooms,id',
        ]);

        // Jika password diisi, update
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diupdate');
    }

    // Delete Users
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
