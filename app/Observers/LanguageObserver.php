<?php

namespace App\Observers;

use App\Models\Language;
use App\Traits\ProcessLog;

class LanguageObserver
{
    use ProcessLog;
    /**
     * Handle the Language "created" event.
     */
    public function created(Language $language): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'created',
            'entity' => Language::class,
            'entity_id' => $language->id,
            'description' => 'Language created with ID: ' . $language->id,
        ]);
    }

    /**
     * Handle the Language "updated" event.
     */
    public function updated(Language $language): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'updated',
            'entity' => Language::class,
            'entity_id' => $language->id,
            'description' => 'Language updated with ID: ' . $language->id,
            'meta' => [
                'old' => json_encode($language->getOriginal()),
                'new' => json_encode($language->getChanges()),
            ],
        ]);
    }

    /**
     * Handle the Language "deleted" event.
     */
    public function deleted(Language $language): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'deleted',
            'entity' => Language::class,
            'entity_id' => $language->id,
            'description' => 'Language deleted with ID: ' . $language->id,
        ]);
    }

    /**
     * Handle the Language "restored" event.
     */
    public function restored(Language $language): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'restored',
            'entity' => Language::class,
            'entity_id' => $language->id,
            'description' => 'Language restored with ID: ' . $language->id,
            'meta' => [
                'old' => json_encode($language->getOriginal()),
                'new' => json_encode($language->getChanges()),
            ]
        ]);
    }

    /**
     * Handle the Language "force deleted" event.
     */
    public function forceDeleted(Language $language): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'force_deleted',
            'entity' => Language::class,
            'entity_id' => $language->id,
            'description' => 'Language force deleted with ID: ' . $language->id,
        ]);
    }
}
