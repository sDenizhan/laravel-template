<?php

namespace App\Observers;

use App\Models\MedicalFormNotes;
use App\Traits\ProcessLog;

class MedicalFormNotesObserver
{
    use ProcessLog;
    /**
     * Handle the MedicalFormNotes "created" event.
     */
    public function created(MedicalFormNotes $medicalFormNotes): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'created',
            'entity' => MedicalFormNotes::class,
            'entity_id' => $medicalFormNotes->id,
            'description' => 'MedicalFormNotes created with ID: ' . $medicalFormNotes->id,
        ]);
    }

    /**
     * Handle the MedicalFormNotes "updated" event.
     */
    public function updated(MedicalFormNotes $medicalFormNotes): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'updated',
            'entity' => MedicalFormNotes::class,
            'entity_id' => $medicalFormNotes->id,
            'description' => 'MedicalFormNotes updated with ID: ' . $medicalFormNotes->id,
            'meta' => [
                'old' => json_encode($medicalFormNotes->getOriginal()),
                'new' => json_encode($medicalFormNotes->getChanges()),
            ],
        ]);
    }

    /**
     * Handle the MedicalFormNotes "deleted" event.
     */
    public function deleted(MedicalFormNotes $medicalFormNotes): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'deleted',
            'entity' => MedicalFormNotes::class,
            'entity_id' => $medicalFormNotes->id,
            'description' => 'MedicalFormNotes deleted with ID: ' . $medicalFormNotes->id,
        ]);
    }

    /**
     * Handle the MedicalFormNotes "restored" event.
     */
    public function restored(MedicalFormNotes $medicalFormNotes): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'restored',
            'entity' => MedicalFormNotes::class,
            'entity_id' => $medicalFormNotes->id,
            'description' => 'MedicalFormNotes restored with ID: ' . $medicalFormNotes->id,
            'meta' => [
                'old' => json_encode($medicalFormNotes->getOriginal()),
                'new' => json_encode($medicalFormNotes->getChanges()),
            ],
        ]);
    }

    /**
     * Handle the MedicalFormNotes "force deleted" event.
     */
    public function forceDeleted(MedicalFormNotes $medicalFormNotes): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'force deleted',
            'entity' => MedicalFormNotes::class,
            'entity_id' => $medicalFormNotes->id,
            'description' => 'MedicalFormNotes force deleted with ID: ' . $medicalFormNotes->id,
        ]);
    }
}
