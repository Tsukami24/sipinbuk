<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAllRead()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $user->unreadNotifications->markAsRead();

        return back();
    }
}
