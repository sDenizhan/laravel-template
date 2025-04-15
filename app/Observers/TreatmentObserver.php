<?php

namespace App\Observers;

use App\Models\Treatments;
use App\Traits\ProcessLog;

class TreatmentObserver
{
    use ProcessLog;

    /**
     * Handle the Treatments "created" event.
     */
    public function created(Treatments $treatments): void
    {
        $this->createLog([
            'user_id' => auth()->id() ?? 0,
            'action' => 'created',
            'entity_type' => Treatments::class,
            'entity_id' => $treatments->id,
            'description' => 'Treatment created with ID: ' . $treatments->id,
        ]);
    }

    /**
     * Handle the Treatments "updated" event.
     */
    public function updated(Treatments $treatments): void
    {
        $this->createLog([
            'user_id' => auth()->id() ?? 0,
            'action' => 'updated',
            'entity_type' => Treatments::class,
            'entity_id' => $treatments->id,
            'description' => 'Treatment updated with ID: ' . $treatments->id,
            'meta' => [
                'old' => $treatments->getOriginal(),
                'new' => $treatments->getChanges(),
            ],
        ]);
    }

    /**
     * Handle the Treatments "deleted" event.
     */
    public function deleted(Treatments $treatments): void
    {
        $this->createLog([
            'user_id' => auth()->id() ?? 0,
            'action' => 'deleted',
            'entity_type' => Treatments::class,
            'entity_id' => $treatments->id,
            'description' => 'Treatment deleted with ID: ' . $treatments->id
        ]);
    }

    /**
     * Handle the Treatments "restored" event.
     */
    public function restored(Treatments $treatments): void
    {
        $this->createLog([
            'user_id' => auth()->id() ?? 0,
            'action' => 'restored',
            'entity_type' => Treatments::class,
            'entity_id' => $treatments->id,
            'description' => 'Treatment restored with ID: ' . $treatments->id,
            'meta' => [
                'old' => $treatments->getOriginal(),
                'new' => $treatments->getChanges(),
            ],
        ]);
    }

    /**
     * Handle the Treatments "force deleted" event.
     */
    public function forceDeleted(Treatments $treatments): void
    {
        $this->createLog([
            'user_id' => auth()->id() ?? 0,
            'action' => 'force_deleted',
            'entity_type' => Treatments::class,
            'entity_id' => $treatments->id,
            'description' => 'Treatment force deleted with ID: ' . $treatments->id,
            'meta' => [
                'old' => $treatments->getOriginal(),
                'new' => $treatments->getChanges(),
            ],
        ]);
    }
}
