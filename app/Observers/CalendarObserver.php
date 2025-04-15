<?php

namespace App\Observers;

use App\Models\Calendar;
use App\Traits\ProcessLog;

class CalendarObserver
{
    use ProcessLog;

    /**
     * Handle the Calendar "created" event.
     */
    public function created(Calendar $calendar): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'created',
            'entity' => Calendar::class,
            'entity_id' => $calendar->id,
            'description' => 'Calendar created with ID: ' . $calendar->id,
        ]);
    }

    /**
     * Handle the Calendar "updated" event.
     */
    public function updated(Calendar $calendar): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'updated',
            'entity' => Calendar::class,
            'entity_id' => $calendar->id,
            'description' => 'Calendar updated with ID: ' . $calendar->id,
            'meta' => [
                'old' => $calendar->getOriginal(),
                'new' => $calendar->getChanges(),
            ],
        ]);
    }

    /**
     * Handle the Calendar "deleted" event.
     */
    public function deleted(Calendar $calendar): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'deleted',
            'entity' => Calendar::class,
            'entity_id' => $calendar->id,
            'description' => 'Calendar deleted with ID: ' . $calendar->id,
        ]);
    }

    /**
     * Handle the Calendar "restored" event.
     */
    public function restored(Calendar $calendar): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'restored',
            'entity' => Calendar::class,
            'entity_id' => $calendar->id,
            'description' => 'Calendar restored with ID: ' . $calendar->id,
            'meta' => [
                'old' => $calendar->getOriginal(),
                'new' => $calendar->getChanges(),
            ],
        ]);
    }

    /**
     * Handle the Calendar "force deleted" event.
     */
    public function forceDeleted(Calendar $calendar): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'force_deleted',
            'entity' => Calendar::class,
            'entity_id' => $calendar->id,
            'description' => 'Calendar force deleted with ID: ' . $calendar->id,
        ]);
    }
}
