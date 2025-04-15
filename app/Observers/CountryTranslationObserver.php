<?php

namespace App\Observers;

use App\Models\CountryTranslation;
use App\Traits\ProcessLog;

class CountryTranslationObserver
{
    use ProcessLog;
    /**
     * Handle the CountryTranslation "created" event.
     */
    public function created(CountryTranslation $countryTranslation): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'create',
            'entity' => CountryTranslation::class,
            'entity_id' => $countryTranslation->id,
            'description' => 'Country translation created for country ID: ' . $countryTranslation->country_id,
        ]);
    }

    /**
     * Handle the CountryTranslation "updated" event.
     */
    public function updated(CountryTranslation $countryTranslation): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'update',
            'entity' => CountryTranslation::class,
            'entity_id' => $countryTranslation->id,
            'description' => 'Country translation updated for country ID: ' . $countryTranslation->country_id,
            'meta' => [
                'old' => $countryTranslation->getOriginal(),
                'new' => $countryTranslation->getChanges(),
            ],
        ]);
    }

    /**
     * Handle the CountryTranslation "deleted" event.
     */
    public function deleted(CountryTranslation $countryTranslation): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'delete',
            'entity' => CountryTranslation::class,
            'entity_id' => $countryTranslation->id,
            'description' => 'Country translation deleted for country ID: ' . $countryTranslation->country_id,
            'meta' => [
                'old' => $countryTranslation->getOriginal(),
                'new' => $countryTranslation->getChanges(),
            ],
        ]);
    }

    /**
     * Handle the CountryTranslation "restored" event.
     */
    public function restored(CountryTranslation $countryTranslation): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'restore',
            'entity' => CountryTranslation::class,
            'entity_id' => $countryTranslation->id,
            'description' => 'Country translation restored for country ID: ' . $countryTranslation->country_id,
            'meta' => [
                'old' => $countryTranslation->getOriginal(),
                'new' => $countryTranslation->getChanges(),
            ],
        ]);
    }

    /**
     * Handle the CountryTranslation "force deleted" event.
     */
    public function forceDeleted(CountryTranslation $countryTranslation): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'force_delete',
            'entity' => CountryTranslation::class,
            'entity_id' => $countryTranslation->id,
            'description' => 'Country translation force deleted for country ID: ' . $countryTranslation->country_id,
            'meta' => [
                'old' => $countryTranslation->getOriginal(),
                'new' => $countryTranslation->getChanges(),
            ],
        ]);
    }
}
