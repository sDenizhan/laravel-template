<?php

namespace App\Observers;

use App\Models\Inquiry;
use App\Traits\ProcessLog;

class InquiryObserver
{
    use ProcessLog;

    /**
     * Handle the Inquiry "created" event.
     */
    public function created(Inquiry $inquiry): void
    {
        // Log the creation of the inquiry
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'created',
            'entity_type' => Inquiry::class,
            'entity_id' => $inquiry->id,
            'description' => 'Inquiry created with ID: ' . $inquiry->id,
        ]);
    }

    /**
     * Handle the Inquiry "updated" event.
     */
    public function updated(Inquiry $inquiry): void
    {
        // Log the update of the inquiry
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'updated',
            'entity_type' => Inquiry::class,
            'entity_id' => $inquiry->id,
            'description' => 'Inquiry updated with ID: ' . $inquiry->id,
            'meta' => [
                'old' => $inquiry->getOriginal(),
                'new' => $inquiry->getChanges(),
            ],
        ]);
    }

    /**
     * Handle the Inquiry "deleted" event.
     */
    public function deleted(Inquiry $inquiry): void
    {
        // Log the deletion of the inquiry
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'deleted',
            'entity_type' => Inquiry::class,
            'entity_id' => $inquiry->id,
            'description' => 'Inquiry deleted with ID: ' . $inquiry->id,
        ]);
    }

    /**
     * Handle the Inquiry "restored" event.
     */
    public function restored(Inquiry $inquiry): void
    {
        // Log the restoration of the inquiry
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'restored',
            'entity_type' => Inquiry::class,
            'entity_id' => $inquiry->id,
            'description' => 'Inquiry restored with ID: ' . $inquiry->id,
            'meta' => [
                'old' => $inquiry->getOriginal(),
                'new' => $inquiry->getChanges(),
            ],
        ]);
    }

    /**
     * Handle the Inquiry "force deleted" event.
     */
    public function forceDeleted(Inquiry $inquiry): void
    {
        // Log the force deletion of the inquiry
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'force deleted',
            'entity_type' => Inquiry::class,
            'entity_id' => $inquiry->id,
            'description' => 'Inquiry force deleted with ID: ' . $inquiry->id,
        ]);
    }
}
