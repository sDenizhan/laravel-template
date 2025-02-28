<?php

namespace App\Listeners;

use App\Enums\InquiryStatus;
use App\Events\EventAfterSendingToDoctor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateInquiryStatusAfterSentDoctor
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
        $event->inquiry->update(['status' => InquiryStatus::DOCTOR_SENT->value]);
    }
}
