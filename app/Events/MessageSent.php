<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Manage_chat;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
	 
	public $message;
	public $files;
	  
    public function __construct(Manage_chat $message,$files)
    {
        $this->message = $message;
        $this->files = $files;
		\Log::info('Message Sent Event Triggered:', ['message' => $message]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
	 
	public function broadcastOn()
    {
        return new Channel('chat-channel'); // Channel Name
    }

    public function broadcastAs()
    {
        return 'message-sent'; // Event Name
	}
	
	public function broadcastWith()
    {
        return [
            'id' => $this->message->id,
            'sender_id' => $this->message->sender_id,
            'receiver_id' => $this->message->receiver_id,
            'message' => $this->message->message,
            'created_at' => $this->message->created_at->toDateTimeString(),
            'files' => $this->files,
        ];
    }
	 
    /*public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }*/
}
