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
Notification::create([
    'user_id' => $property->user_id,
    'type' => 'message',
    'title' => 'New Message',
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
}
