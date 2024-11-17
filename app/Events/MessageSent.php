<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    // Specify the channel the event will broadcast on
    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->message->to_user_id);
    }

    // Customize the event name that the client will listen for
    public function broadcastAs()
    {
        return 'message.sent';
    }
}
