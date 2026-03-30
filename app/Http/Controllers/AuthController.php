<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class AuthController extends Controller
{
    // User Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('user.home');
        }

        return back()->withErrors([
            'email' => 'email anda salah',
            'password' => 'passwod anda salah',
        ]);
    }

    // Send OTP for Password Reset
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan']);
        }

        $otp = mt_rand(100000, 999999);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10)
        ]);

        session(['otp_email' => $user->email]);

        Mail::to($user->email)->send(new OtpMail($otp));

        return redirect()->route('auth.verify-otp')
            ->with('success', 'Kode OTP telah dikirim ke email Anda');
    }


    // Verevify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        $user = User::where('email', session('otp_email'))
            ->where('otp', trim($request->otp))
            ->where('otp_expires_at', '>=', now())
            ->first();

        if (!$user) {
            return back()->withErrors(['otp' => 'OTP salah atau kadaluarsa']);
        }

        // simpan untuk halaman password baru
        session(['reset_email' => $user->email]);

        return redirect()->route('auth.new-password');
    }



    // Update New Password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed'
        ]);

        $email = session('reset_email');

        if (!$email) {
            return redirect()->route('auth.forgot-password')
                ->withErrors(['email' => 'Sesi reset password telah habis']);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('auth.forgot-password')
                ->withErrors(['email' => 'User tidak ditemukan']);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'otp' => null,
            'otp_expires_at' => null
        ]);

        session()->forget('reset_email');

        return redirect()->route('login')
            ->with('success', 'Password berhasil direset');
    }


    // User Logout
    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }

}
