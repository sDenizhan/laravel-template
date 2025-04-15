<?php

namespace App\Observers;

use App\Models\MedicalFormQuestionAnswer;
use App\Traits\ProcessLog;

class MedicalFormQuestionAnswerObserver
{
    use ProcessLog;
    /**
     * Handle the MedicalFormQuestionAnswer "created" event.
     */
    public function created(MedicalFormQuestionAnswer $medicalFormQuestionAnswer): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'created',
            'entity' => MedicalFormQuestionAnswer::class,
            'entity_id' => $medicalFormQuestionAnswer->id,
            'description' => 'MedicalFormQuestionAnswer created with ID: ' . $medicalFormQuestionAnswer->id,
        ]);
    }

    /**
     * Handle the MedicalFormQuestionAnswer "updated" event.
     */
    public function updated(MedicalFormQuestionAnswer $medicalFormQuestionAnswer): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'updated',
            'entity' => MedicalFormQuestionAnswer::class,
            'entity_id' => $medicalFormQuestionAnswer->id,
            'description' => 'MedicalFormQuestionAnswer updated with ID: ' . $medicalFormQuestionAnswer->id,
            'meta' => [
                'old' => json_encode($medicalFormQuestionAnswer->getOriginal()),
                'new' => json_encode($medicalFormQuestionAnswer->getChanges()),
            ],
        ]);
    }

    /**
     * Handle the MedicalFormQuestionAnswer "deleted" event.
     */
    public function deleted(MedicalFormQuestionAnswer $medicalFormQuestionAnswer): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'deleted',
            'entity' => MedicalFormQuestionAnswer::class,
            'entity_id' => $medicalFormQuestionAnswer->id,
            'description' => 'MedicalFormQuestionAnswer deleted with ID: ' . $medicalFormQuestionAnswer->id,
        ]);
    }

    /**
     * Handle the MedicalFormQuestionAnswer "restored" event.
     */
    public function restored(MedicalFormQuestionAnswer $medicalFormQuestionAnswer): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'restored',
            'entity' => MedicalFormQuestionAnswer::class,
            'entity_id' => $medicalFormQuestionAnswer->id,
            'description' => 'MedicalFormQuestionAnswer restored with ID: ' . $medicalFormQuestionAnswer->id,
            'meta' => [
                'old' => json_encode($medicalFormQuestionAnswer->getOriginal()),
                'new' => json_encode($medicalFormQuestionAnswer->getChanges()),
            ],
        ]);
    }

    /**
     * Handle the MedicalFormQuestionAnswer "force deleted" event.
     */
    public function forceDeleted(MedicalFormQuestionAnswer $medicalFormQuestionAnswer): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'force deleted',
            'entity' => MedicalFormQuestionAnswer::class,
            'entity_id' => $medicalFormQuestionAnswer->id,
            'description' => 'MedicalFormQuestionAnswer force deleted with ID: ' . $medicalFormQuestionAnswer->id,
        ]);
    }
}
