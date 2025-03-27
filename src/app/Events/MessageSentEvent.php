<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $message;
    public $senderId;
    public $receiverId;
    public $userName;
    public $channelName;

    public function __construct($message, $senderId, $receiverId, $userName, $channelName)
    {
        $this->message = $message;
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->userName = $userName;
        $this->channelName = $channelName;
    }

    public function broadcastOn(): Channel
    {
        return new Channel($this->channelName);
    }


    public function broadcastWith()
    {
        return [
            'userName' => $this->userName,
            'message' => $this->message,
            'channelName' => $this->channelName,
        ];
    }
}
