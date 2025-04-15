<?php

namespace App\Observers;

use App\Models\MessageTemplate;
use App\Traits\ProcessLog;

class MessageTemplateObserver
{
    use ProcessLog;

    /**
     * Handle the MessageTemplate "created" event.
     */
    public function created(MessageTemplate $messageTemplate): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'created',
            'entity' => MessageTemplate::class,
            'entity_id' => $messageTemplate->id,
            'description' => 'MessageTemplate created with ID: ' . $messageTemplate->id,
        ]);
    }

    /**
     * Handle the MessageTemplate "updated" event.
     */
    public function updated(MessageTemplate $messageTemplate): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'updated',
            'entity' => MessageTemplate::class,
            'entity_id' => $messageTemplate->id,
            'description' => 'MessageTemplate updated with ID: ' . $messageTemplate->id,
            'meta' => [
                'old' => json_encode($messageTemplate->getOriginal()),
                'new' => json_encode($messageTemplate->getChanges()),
            ],
        ]);
    }

    /**
     * Handle the MessageTemplate "deleted" event.
     */
    public function deleted(MessageTemplate $messageTemplate): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'deleted',
            'entity' => MessageTemplate::class,
            'entity_id' => $messageTemplate->id,
            'description' => 'MessageTemplate deleted with ID: ' . $messageTemplate->id,
        ]);
    }

    /**
     * Handle the MessageTemplate "restored" event.
     */
    public function restored(MessageTemplate $messageTemplate): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'restored',
            'entity' => MessageTemplate::class,
            'entity_id' => $messageTemplate->id,
            'description' => 'MessageTemplate restored with ID: ' . $messageTemplate->id,
            'meta' => [
                'old' => json_encode($messageTemplate->getOriginal()),
                'new' => json_encode($messageTemplate->getChanges()),
            ],
        ]);
    }

    /**
     * Handle the MessageTemplate "force deleted" event.
     */
    public function forceDeleted(MessageTemplate $messageTemplate): void
    {
        $this->createLog([
            'user_id' => auth()->user()->id ?? 0,
            'action' => 'force deleted',
            'entity' => MessageTemplate::class,
            'entity_id' => $messageTemplate->id,
            'description' => 'MessageTemplate force deleted with ID: ' . $messageTemplate->id,
        ]);
    }
}
