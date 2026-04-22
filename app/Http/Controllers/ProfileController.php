<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('user.profile.index');
    }

    public function editPassword()
    {
        return view('user.profile.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        $user = User::find(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama salah');
        }

        if ($request->current_password === $request->password) {
            return back()->with('error', 'Password baru harus berbeda dari password lama');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah');
    }
}
