<?php

namespace App\Observers;

use App\Models\MedicalFormQuestion;
use App\Traits\ProcessLog;

class MedicalFormQuestionObserver
{
    use ProcessLog;

    /**
     * Handle the MedicalFormQuestion "created" event.
     */
    public function created(MedicalFormQuestion $medicalFormQuestion): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'created',
            'entity' => MedicalFormQuestion::class,
            'entity_id' => $medicalFormQuestion->id,
            'description' => 'MedicalFormQuestion created with ID: ' . $medicalFormQuestion->id,
        ]);
    }

    /**
     * Handle the MedicalFormQuestion "updated" event.
     */
    public function updated(MedicalFormQuestion $medicalFormQuestion): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'updated',
            'entity' => MedicalFormQuestion::class,
            'entity_id' => $medicalFormQuestion->id,
            'description' => 'MedicalFormQuestion updated with ID: ' . $medicalFormQuestion->id,
            'meta' => [
                'old' => json_encode($medicalFormQuestion->getOriginal()),
                'new' => json_encode($medicalFormQuestion->getChanges()),
            ],
        ]);
    }

    /**
     * Handle the MedicalFormQuestion "deleted" event.
     */
    public function deleted(MedicalFormQuestion $medicalFormQuestion): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'deleted',
            'entity' => MedicalFormQuestion::class,
            'entity_id' => $medicalFormQuestion->id,
            'description' => 'MedicalFormQuestion deleted with ID: ' . $medicalFormQuestion->id,
        ]);
    }

    /**
     * Handle the MedicalFormQuestion "restored" event.
     */
    public function restored(MedicalFormQuestion $medicalFormQuestion): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'restored',
            'entity' => MedicalFormQuestion::class,
            'entity_id' => $medicalFormQuestion->id,
            'description' => 'MedicalFormQuestion restored with ID: ' . $medicalFormQuestion->id,
            'meta' => [
                'old' => json_encode($medicalFormQuestion->getOriginal()),
                'new' => json_encode($medicalFormQuestion->getChanges()),
            ],
        ]);
    }

    /**
     * Handle the MedicalFormQuestion "force deleted" event.
     */
    public function forceDeleted(MedicalFormQuestion $medicalFormQuestion): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'force deleted',
            'entity' => MedicalFormQuestion::class,
            'entity_id' => $medicalFormQuestion->id,
            'description' => 'MedicalFormQuestion force deleted with ID: ' . $medicalFormQuestion->id,
        ]);
    }
}
