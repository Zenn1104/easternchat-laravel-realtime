<?php

namespace App\Events;

use App\Models\Message; // Pastikan ini diimpor
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $group_id;
    public string $content;
    public string $username;
    public string $created_at;
    public string $sender_id;
    /**
     * Create a new event instance.
     *
     * @param Message $message Instance dari model Message.
     */
    public function __construct(string $sender_id, Message $message) // Tipe parameter diperjelas
    {
        $this->content = $message->content;
        $this->sender_id = $sender_id;
        $this->username = User::find($sender_id)->name;
        $this->created_at = $message->created_at;
        $this->group_id = $message->group_id;
    }

    public function broadcastOn(): array
    {
        return [ 
            new Channel('group-info'), 
            new PrivateChannel('group.' . $this->group_id), 
        ];
    }

    public function broadcatsAs(): string
    {
        return 'MessageSent';
    }

    public function broadcatsWith(): array
    {
        Log::info('Message event broadcatsed: ', ['group_id' => $this->group_id]);
        return ['group_id' => $this->group_id];
    }
}