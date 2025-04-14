<?php

namespace App\Traits;

use App\Models\ProcessLog as Model;

trait ProcessLog
{
    public function createLog(?array $data = []): void
    {
        $user = auth()->user();

        if (!$user) {
            return;
        }

        Model::create([
            'user_id' => $data['user_id'] ?? $user->id,
            'action' => $data['action'] ?? null,
            'entity_type' => $data['entity_type'] ?? null,
            'entity_id' => $data['entity_id'] ?? null,
            'description' => $data['description'] ?? null,
            'meta' => $data['meta'] ?? null,
        ]);
    }
}
