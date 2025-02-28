<?php

namespace App\Listeners;

use App\Events\EventAfterSendingToDoctor;
use App\Models\DoctorHasInquiry;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddRecordAfterSendingToDoctor
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EventAfterSendingToDoctor $event): void
    {

        foreach ($event->doctors as $doctor){
            DoctorHasInquiry::create([
                'doctor_id' => $doctor->id,
                'inquiry_id' => $event->inquiry->id,
                'status' => 1,
            ]);
        }
    }
}
