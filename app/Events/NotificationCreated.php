<?php
namespace App\Events;

use App\Models\Notification;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;

class NotificationCreated implements ShouldBroadcast
{
   use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;
    public $unreadCount;

    public function __construct(Notification $notification, $unreadCount)
    {
        $this->notification = $notification;
        $this->unreadCount = $unreadCount;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->notification->user_id);
    }

    public function broadcastAs()
    {
        return 'notification.created';
    }
public function broadcastWith()
{
    return [
        'id' => $this->notification->id,
        'title' => $this->notification->title,
        'body' => $this->notification->body,
        'property_id' => $this->notification->property_id,
        'unreadCount' => $this->unreadCount,
    ];
}
