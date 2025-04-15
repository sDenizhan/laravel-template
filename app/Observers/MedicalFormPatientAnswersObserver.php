<?php

namespace App\Observers;

use App\Models\MedicalFormPatientAnswers;
use App\Traits\ProcessLog;

class MedicalFormPatientAnswersObserver
{
    use ProcessLog;
    /**
     * Handle the MedicalFormPatientAnswers "created" event.
     */
    public function created(MedicalFormPatientAnswers $medicalFormPatientAnswers): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'created',
            'entity' => MedicalFormPatientAnswers::class,
            'entity_id' => $medicalFormPatientAnswers->id,
            'description' => 'MedicalFormPatientAnswers created with ID: ' . $medicalFormPatientAnswers->id,
        ]);
    }

    /**
     * Handle the MedicalFormPatientAnswers "updated" event.
     */
    public function updated(MedicalFormPatientAnswers $medicalFormPatientAnswers): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'updated',
            'entity' => MedicalFormPatientAnswers::class,
            'entity_id' => $medicalFormPatientAnswers->id,
            'description' => 'MedicalFormPatientAnswers updated with ID: ' . $medicalFormPatientAnswers->id,
            'meta' => [
                'old' => json_encode($medicalFormPatientAnswers->getOriginal()),
                'new' => json_encode($medicalFormPatientAnswers->getChanges()),
            ],
        ]);
    }

    /**
     * Handle the MedicalFormPatientAnswers "deleted" event.
     */
    public function deleted(MedicalFormPatientAnswers $medicalFormPatientAnswers): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'deleted',
            'entity' => MedicalFormPatientAnswers::class,
            'entity_id' => $medicalFormPatientAnswers->id,
            'description' => 'MedicalFormPatientAnswers deleted with ID: ' . $medicalFormPatientAnswers->id,
        ]);
    }

    /**
     * Handle the MedicalFormPatientAnswers "restored" event.
     */
    public function restored(MedicalFormPatientAnswers $medicalFormPatientAnswers): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'restored',
            'entity' => MedicalFormPatientAnswers::class,
            'entity_id' => $medicalFormPatientAnswers->id,
            'description' => 'MedicalFormPatientAnswers restored with ID: ' . $medicalFormPatientAnswers->id,
            'meta' => [
                'old' => json_encode($medicalFormPatientAnswers->getOriginal()),
                'new' => json_encode($medicalFormPatientAnswers->getChanges()),
            ],
        ]);
    }

    /**
     * Handle the MedicalFormPatientAnswers "force deleted" event.
     */
    public function forceDeleted(MedicalFormPatientAnswers $medicalFormPatientAnswers): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'force_deleted',
            'entity' => MedicalFormPatientAnswers::class,
            'entity_id' => $medicalFormPatientAnswers->id,
            'description' => 'MedicalFormPatientAnswers force deleted with ID: ' . $medicalFormPatientAnswers->id,
        ]);
    }
}
