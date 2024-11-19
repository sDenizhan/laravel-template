<?php

namespace App\Listeners;

use App\Enums\InquiryStatus;
use App\Events\EventAfterSendingToAnaesthetistDoctors;
use App\Models\Inquiry;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateInquiryStatusAfterSentAnaesthetistDoctor
{
    public function handle(EventAfterSendingToAnaesthetistDoctors $event): void
    {
        $event->inquiry->update(['status' => InquiryStatus::ANESTHESIA_SENT->value]);
    }
}
