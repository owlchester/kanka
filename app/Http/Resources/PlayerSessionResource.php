<?php

namespace App\Http\Resources;

use App\Models\PlayerSession;

class PlayerSessionResource extends ModelResource
{
    public function toArray($request): array
    {
        /** @var PlayerSession $session */
        $session = $this->resource;

        return [
            'id' => $session->id,
            'entity_claim_id' => $session->entity_claim_id,
            'name' => $session->name,
            'started_at' => $session->started_at,
            'ended_at' => $session->ended_at,
            'summary' => $session->summary,
            'created_at' => $session->created_at,
            'updated_at' => $session->updated_at,
            'created_by' => $session->created_by,
        ];
    }
}
