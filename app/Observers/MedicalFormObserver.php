<?php

namespace App\Observers;

use App\Models\MedicalForm;
use App\Traits\ProcessLog;

class MedicalFormObserver
{
    use ProcessLog;

    /**
     * Handle the MedicalForm "created" event.
     */
    public function created(MedicalForm $medicalForm): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'created',
            'entity' => MedicalForm::class,
            'entity_id' => $medicalForm->id,
            'description' => 'MedicalForm created with ID: ' . $medicalForm->id,
        ]);
    }

    /**
     * Handle the MedicalForm "updated" event.
     */
    public function updated(MedicalForm $medicalForm): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'updated',
            'entity' => MedicalForm::class,
            'entity_id' => $medicalForm->id,
            'description' => 'MedicalForm updated with ID: ' . $medicalForm->id,
            'meta' => [
                'old' => json_encode($medicalForm->getOriginal()),
                'new' => json_encode($medicalForm->getChanges()),
            ],
        ]);
    }

    /**
     * Handle the MedicalForm "deleted" event.
     */
    public function deleted(MedicalForm $medicalForm): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'deleted',
            'entity' => MedicalForm::class,
            'entity_id' => $medicalForm->id,
            'description' => 'MedicalForm deleted with ID: ' . $medicalForm->id,
        ]);
    }

    /**
     * Handle the MedicalForm "restored" event.
     */
    public function restored(MedicalForm $medicalForm): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'restored',
            'entity' => MedicalForm::class,
            'entity_id' => $medicalForm->id,
            'description' => 'MedicalForm restored with ID: ' . $medicalForm->id,
            'meta' => [
                'old' => json_encode($medicalForm->getOriginal()),
                'new' => json_encode($medicalForm->getChanges()),
            ],
        ]);
    }

    /**
     * Handle the MedicalForm "force deleted" event.
     */
    public function forceDeleted(MedicalForm $medicalForm): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'force_deleted',
            'entity' => MedicalForm::class,
            'entity_id' => $medicalForm->id,
            'description' => 'MedicalForm force deleted with ID: ' . $medicalForm->id,
        ]);
    }
}
