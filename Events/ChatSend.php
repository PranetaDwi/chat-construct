<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Chat;

class ChatSend implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // public $chat;

    public $message;
    public $project_progress_id;
    public $user;
    public $sender;
    public $receiver;
    public $time;

    /**
     * Create a new event instance.
     */
    // public function __construct(Chat $chat)
    // {
    //     $this->chat = $chat;
    // }

    public function __construct($message, $project_progress_id, $user, $sender, $receiver, $time)
    {
        $this->message = $message;
        $this->project_progress_id = $project_progress_id;
        $this->user = $user;
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->time = $time;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn() : Channel
    {
            return new PrivateChannel('project-progress.' . $this->project_progress_id);

    }

    public function broadcastAs()
    {
        return 'chat.sent';
    }

    
}
