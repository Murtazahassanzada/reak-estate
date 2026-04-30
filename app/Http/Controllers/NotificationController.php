<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $messages = Message::with(['sender','property'])
            ->where('receiver_id', $userId)
            ->latest()
            ->get();

        $notifications = Notification::where('user_id', $userId)
            ->latest()
            ->get();

        return view('inbox', compact('messages','notifications'));
    }

    // 🔥 برای navbar (badge + dropdown)
    public function fetch()
    {
        $userId = auth()->id();

        $notifications = Notification::where('user_id', $userId)
            ->latest()
            ->take(10)
            ->get();

        $unread = Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread' => $unread
        ]);
    }

    // 🔥 mark all as read (FIX شده)
public function markAll()
{
    Notification::where('user_id', auth()->id())
        ->update(['is_read' => true]);

    return response()->json([
        'success' => true
    ]);
}

    // 🔥 mark single notification
    public function readAjax($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $notification->update(['is_read' => true]);

        $unread = Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();

        return response()->json([
            'success' => true,
            'unread' => $unread
        ]);
    }
}
