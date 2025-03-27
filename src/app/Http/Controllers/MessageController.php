<?php

namespace App\Http\Controllers;

use App\Events\MessageSentEvent;
use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class MessageController extends Controller
{
    public function sendMessage(Request $request, $receiverId)
    {
        $message = $request->input('message');
        $channelName = $request->input('channelName');
        $senderId = Auth::user()->id;
        $userName = Auth::user()->name;

        // dd($channelName);
        // Broadcast the message
        // broadcast(new MessageSentEvent($message, $senderId, $receiverId, $userName, $channelName))->toOthers();
        event(new MessageSentEvent($message, $senderId, $receiverId, $userName, $channelName));
        // MessageSentEvent::dispatch($message, $senderId, $receiverId, $userName, $channelName);

        return response()->json(['status' => 'Message sent!']);
    }
}