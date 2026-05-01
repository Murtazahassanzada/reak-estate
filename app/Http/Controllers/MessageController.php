<?php

namespace App\Http\Controllers;
use App\Events\NotificationCreated;
use App\Models\Notification;
use App\Models\Message;
use App\Models\Property;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function send(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|min:3'
        ]);

        $property = Property::findOrFail($id);

        // جلوگیری از ارسال به خود
        if ($property->user_id == auth()->id()) {
            return back()->with('error','You cannot message yourself');
        }

        // ذخیره پیام
        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $property->user_id,
            'property_id' => $property->id,
            'message' => $request->message
        ]);

        // 🔔 ساخت notification (SAFE)
$notification = Notification::create([
    'user_id' => $property->user_id,
    'type' => 'contact',
    'title' => 'New Contact Message',
    'body' => $request->message,
    'property_id' => $property->id,
    'is_read' => false
]);

$unread = Notification::where('user_id', $property->user_id)
    ->where('is_read', false)
    ->count();

event(new NotificationCreated($notification, $unread));

        return back()->with('success','Message sent successfully');
    }
public function reply(Request $request, $notificationId)
{
    $request->validate([
        'message' => 'required|min:2'
    ]);

    $notification = Notification::findOrFail($notificationId);

    $oldMessage = Message::where('property_id', $notification->property_id)
        ->where('sender_id', '!=', auth()->id())
        ->latest()
        ->first();

    if (!$oldMessage) {
        return back()->with('error', 'Message not found');
    }
dd($oldMessage);
    Message::create([
        'sender_id' => auth()->id(),
        'receiver_id' => $oldMessage->sender_id,
        'property_id' => $oldMessage->property_id,
        'message' => $request->message,
    ]);

    Notification::create([
        'user_id' => $oldMessage->sender_id,
        'type' => 'reply',
        'title' => 'Admin Reply',
        'body' => auth()->user()->name . ': ' . $request->message,
        'property_id' => $oldMessage->property_id,
        'is_read' => false,
    ]);

    return back()->with('success', 'Reply sent');
}
}
