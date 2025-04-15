<?php

namespace App\Providers;

use App\Events\EventAfterSendingToAnaesthetistDoctors;
use App\Events\EventAfterSendingToDoctor;
use App\Events\InquiryCreated;
use App\Events\InquiryDeleted;
use App\Events\InquiryStoredEvent;
use App\Events\InquiryUpdated;
use App\Events\MedicalFormSentEvent;
use App\Listeners\AddRecordAfterSendingToAanaesthetist;
use App\Listeners\AddRecordAfterSendingToDoctor;
use App\Listeners\CheckUserLocationFromIpAddress;
use App\Listeners\InquiryCreatedListener;
use App\Listeners\InquiryDeletedListener;
use App\Listeners\InquiryStoredListener;
use App\Listeners\InquiryUpdatedListener;
use App\Listeners\ListenerSendingEmailtoAnaesthetistDoctors;
use App\Listeners\ListenerSendingNotifytoAnaesthetistDoctors;
use App\Listeners\UpdateInquiryStatusAfterSentAnaesthetistDoctor;
use App\Listeners\UpdateInquiryStatusAfterSentDoctor;
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
        InquiryStoredEvent::class => [
            InquiryStoredListener::class
        ],
        InquiryCreated::class => [
            InquiryCreatedListener::class
        ],
        InquiryUpdated::class => [
            InquiryUpdatedListener::class
        ],
        InquiryDeleted::class => [
            InquiryDeletedListener::class
        ],
        EventAfterSendingToAnaesthetistDoctors::class => [
            //ListenerSendingEmailtoAnaesthetistDoctors::class,
            //ListenerSendingNotifytoAnaesthetistDoctors::class,
            UpdateInquiryStatusAfterSentAnaesthetistDoctor::class,
            AddRecordAfterSendingToAanaesthetist::class
        ],
        MedicalFormSentEvent::class => [
            UpdateInquiryStatusAfterWhatsappMessage::class
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Login::class => [
            CheckUserLocationFromIpAddress::class
        ],
        EventAfterSendingToDoctor::class => [
            UpdateInquiryStatusAfterSentDoctor::class,
            AddRecordAfterSendingToDoctor::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        $this->observerLoader([
            'App\Models\City' => 'App\Observers\CityObserver',
            'App\Models\Country' => 'App\Observers\CountryObserver',
            'App\Models\Calendar' => 'App\Observers\CalendarObserver',
            'App\Models\Inquiry' => 'App\Observers\InquiryObserver',
        ]);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }

    private function observerLoader(?array $observers = []): void
    {
        if (empty($observers)) {
            return;
        }

        foreach ($observers as $model => $observer) {
            $model::observe($observer);
        }
    }
}
