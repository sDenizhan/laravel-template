<?php

namespace App\Listeners;

use App\Events\EventAfterSendingToAnaesthetistDoctors;
use App\Models\DoctorHasInquiry;
use App\Models\Inquiry;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddRecordAfterSendingToAanaesthetist
{
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(EventAfterSendingToAnaesthetistDoctors $event): void
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
