<?php

namespace App\Observers;

use App\Models\Hospital;
use App\Traits\ProcessLog;

class HospitalObserver
{
    use ProcessLog;
    /**
     * Handle the Hospital "created" event.
     */
    public function created(Hospital $hospital): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? null,
            'action' => 'created',
            'entity' => Hospital::class,
            'entity_id' => $hospital->id,
            'description' => 'Hospital created: ' . $hospital->name,
        ]);
    }

    /**
     * Handle the Hospital "updated" event.
     */
    public function updated(Hospital $hospital): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? null,
            'action' => 'updated',
            'entity' => Hospital::class,
            'entity_id' => $hospital->id,
            'description' => 'Hospital updated: ' . $hospital->name,
            'meta' => [
                'old' => json_encode($hospital->getOriginal()),
                'new' => json_encode($hospital->getChanges()),
            ]
        ]);
    }

    /**
     * Handle the Hospital "deleted" event.
     */
    public function deleted(Hospital $hospital): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? null,
            'action' => 'deleted',
            'entity' => Hospital::class,
            'entity_id' => $hospital->id,
            'description' => 'Hospital deleted: ' . $hospital->name,
        ]);
    }

    /**
     * Handle the Hospital "restored" event.
     */
    public function restored(Hospital $hospital): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? null,
            'action' => 'restored',
            'entity' => Hospital::class,
            'entity_id' => $hospital->id,
            'description' => 'Hospital restored: ' . $hospital->name,
            'meta' => [
                'old' => json_encode($hospital->getOriginal()),
                'new' => json_encode($hospital->getChanges()),
            ]
        ]);
    }

    /**
     * Handle the Hospital "force deleted" event.
     */
    public function forceDeleted(Hospital $hospital): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? null,
            'action' => 'force deleted',
            'entity' => Hospital::class,
            'entity_id' => $hospital->id,
            'description' => 'Hospital force deleted: ' . $hospital->name,
        ]);
    }
}
