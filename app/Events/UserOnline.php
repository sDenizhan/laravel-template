<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class UserOnline implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    /**
     * Create a new event instance.
     */
    public function __construct($user)
    {
        $this->user = $user;

        //cache
        Cache::put('online-user-'. $user->id, true, now()->addMinutes(15));

        $onlineUsers = Cache::get('onlineUsers', []);
        $onlineUsers[$user->id] = $user;

        Cache::put('onlineUsers', $onlineUsers, now()->addMinutes(15));

        //last seen
        $user->last_seen = now();
        $user->save();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        return new Channel('user-online');
    }

    public function broadcastAs(): string
    {
        return 'online.users';
    }

    public function broadcastWith(): array
    {
        return [
            'user' => $this->user,
        ];
    }

}
