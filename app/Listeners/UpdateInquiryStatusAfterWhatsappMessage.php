<?php

namespace App\Listeners;

use App\Enums\InquiryStatus;
use App\Events\MedicalFormSentEvent;
use App\Models\Inquiry;
use App\Models\User;

class UpdateInquiryStatusAfterWhatsappMessage
{
    /**
     * Handle the event.
     */
    public function handle(MedicalFormSentEvent $event): void
    {
        $event->inquiry->update(['status' => InquiryStatus::FORM_SENT->value]);
    }
}
