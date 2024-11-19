<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ListenerSendingNotifytoAnaesthetistDoctors
{
    private $doctors = [];

    private $inquiry = null;
    /**
     * Create the event listener.
     */
    public function __construct($doctors, $inquiry)
    {
        $this->inquiry = $inquiry;
        $this->doctors = $doctors;
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $inquiry = $this->inquiry;
        $doctors = $this->doctors;

        foreach ($doctors as $doctor) {
            $data = [
                'doctor' => $doctor,
                'inquiry' => $inquiry,
            ];

            $doctor->notify(new \App\Notifications\InquiryNotificationForAnaesthetistDoctors($data));
        }
    }
}
