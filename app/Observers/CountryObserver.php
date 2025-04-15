<?php

namespace App\Observers;

use App\Models\Country;
use App\Traits\ProcessLog;

class CountryObserver
{
    use ProcessLog;
    /**
     * Handle the Country "created" event.
     */
    public function created(Country $country): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'created',
            'entity' => Country::class,
            'entity_id' => $country->id,
            'description' => 'Country created with ID: ' . $country->id,
        ]);
    }

    /**
     * Handle the Country "updated" event.
     */
    public function updated(Country $country): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'updated',
            'entity' => Country::class,
            'entity_id' => $country->id,
            'description' => 'Country updated with ID: ' . $country->id,
            'meta' => [
                'old' => json_encode($country->getOriginal()),
                'new' => json_encode($country->getChanges()),
            ],
        ]);
    }

    /**
     * Handle the Country "deleted" event.
     */
    public function deleted(Country $country): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'deleted',
            'entity' => Country::class,
            'entity_id' => $country->id,
            'description' => 'Country deleted with ID: ' . $country->id,
        ]);
    }

    /**
     * Handle the Country "restored" event.
     */
    public function restored(Country $country): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'restored',
            'entity' => Country::class,
            'entity_id' => $country->id,
            'description' => 'Country restored with ID: ' . $country->id,
            'meta' => [
                'old' => json_encode($country->getOriginal()),
                'new' => json_encode($country->getChanges()),
            ],
        ]);
    }

    /**
     * Handle the Country "force deleted" event.
     */
    public function forceDeleted(Country $country): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'force_deleted',
            'entity' => Country::class,
            'entity_id' => $country->id,
            'description' => 'Country force deleted with ID: ' . $country->id,
            'meta' => [
                'old' => json_encode($country->getOriginal()),
                'new' => json_encode($country->getChanges()),
            ],
        ]);
    }
}
