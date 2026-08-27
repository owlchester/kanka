<?php

namespace App\Http\Resources;

use App\Models\InteractionLog;

class InteractionLogResource extends ModelResource
{
    public function toArray($request): array
    {
        /** @var InteractionLog $log */
        $log = $this->resource;

        return [
            'id' => $log->id,
            'player_session_id' => $log->player_session_id,
            'entity_id' => $log->entity_id,
            'entity_claim_id' => $log->entity_claim_id,
            'note' => $log->note,
            'visibility' => $log->effectiveVisibility()->value,
            'created_at' => $log->created_at,
            'updated_at' => $log->updated_at,
            'created_by' => $log->created_by,
        ];
    }
}
