<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventAfterSendingToAnaesthetistDoctors
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $doctors;
    public $inquiry;

    /**
     * Create a new event instance.
     */
    public function __construct($doctors, $inquiry)
    {
        $this->doctors = $doctors;
        $this->inquiry = $inquiry;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
