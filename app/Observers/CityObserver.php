<?php

namespace App\Observers;

use App\Models\City;
use App\Traits\ProcessLog;

class CityObserver
{
    use ProcessLog;

    /**
     * Handle the City "created" event.
     */
    public function created(City $city): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'created',
            'entity' => 'city',
            'entity_id' => $city->id,
            'description' => 'City created with ID: ' . $city->id,
        ]);
    }

    /**
     * Handle the City "updated" event.
     */
    public function updated(City $city): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'updated',
            'entity' => 'city',
            'entity_id' => $city->id,
            'description' => 'City updated with ID: ' . $city->id,
            'meta' => [
                'old' => json_encode($city->getOriginal()),
                'new' => json_encode($city->getChanges()),
            ],
        ]);
    }

    /**
     * Handle the City "deleted" event.
     */
    public function deleted(City $city): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'deleted',
            'entity' => 'city',
            'entity_id' => $city->id,
            'description' => 'City deleted with ID: ' . $city->id,
        ]);
    }

    /**
     * Handle the City "restored" event.
     */
    public function restored(City $city): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'restored',
            'entity' => 'city',
            'entity_id' => $city->id,
            'description' => 'City restored with ID: ' . $city->id,
            'meta' => [
                'old' => json_encode($city->getOriginal()),
                'new' => json_encode($city->getChanges()),
            ],
        ]);
    }

    /**
     * Handle the City "force deleted" event.
     */
    public function forceDeleted(City $city): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'force_deleted',
            'entity' => 'city',
            'entity_id' => $city->id,
            'description' => 'City force deleted with ID: ' . $city->id,
        ]);
    }
}
