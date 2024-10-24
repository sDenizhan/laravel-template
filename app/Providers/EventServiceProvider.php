<?php

namespace App\Providers;

use App\Events\InquiryStoredEvent;
use App\Events\MedicalFormSentEvent;
use App\Listeners\CheckUserLocationFromIpAddress;
use App\Listeners\InquiryStoredListener;
use App\Listeners\UpdateInquiryStatusAfterWhatsappMessage;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        MedicalFormSentEvent::class => [
            UpdateInquiryStatusAfterWhatsappMessage::class
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        InquiryStoredEvent::class => [
            InquiryStoredListener::class
        ],
        Login::class => [
            CheckUserLocationFromIpAddress::class
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
