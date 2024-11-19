<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ListenerSendingEmailtoAnaesthetistDoctors
{
    /**
     * Create the event listener.
     */

    private $doctors = [];
    private $inquiry = null;

    public function __construct($doctors, $inquiry)
    {
        $this->doctors = $doctors;
        $this->inquiry = $inquiry;
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

            \Mail::send('emails.inquiry', $data, function ($message) use ($doctor) {
                $message->to($doctor->email, $doctor->name)->subject('New Inquiry');
            });
        }
    }
}
