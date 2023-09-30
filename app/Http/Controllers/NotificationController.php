<?php

namespace App\Http\Controllers;

use App\Notification;
use App\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead(Request $request, $notification)
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $notification = Notification::findOrFail($notification);
        
        if ($notification) {
            $notification->update(['read_at' => now()]);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
