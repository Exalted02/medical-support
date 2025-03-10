<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageUpdated implements ShouldBroadcast
{
    public $message;
	public $id;

    public function __construct($message)
    {
		//\Log::info('MessageUpdated Event Data:', ['message' => $message->toArray()]);
        //$this->message = $message;
		$this->id = $message->id;
        $this->message = $message->message;
    }

    public function broadcastOn()
    {
        return new Channel('chat-channel');
    }
	public function broadcastAs()
    {
        return 'message-updated';
    }
	public function broadcastWith()
	{
		return [
			'id' => $this->id,
			'message' => $this->message
		];
	}
}
