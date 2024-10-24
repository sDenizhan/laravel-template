<?php

namespace App\Events;

use App\Models\Inquiry;
use App\Models\MedicalFormPatientAnswers;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MedicalFormSentEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $medicalFormPatientAnswers;
    public $user;
    public $inquiry;

    /**
     * Create a new event instance.
     */
    public function __construct($inquiry, $user, $medicalFormPatientAnswers)
    {
        $this->inquiry = $inquiry;
        $this->user = $user;
        $this->medicalFormPatientAnswers = $medicalFormPatientAnswers;
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
