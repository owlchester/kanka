<?php

namespace App\Http\Resources;

use App\Enums\InteractionLogAttitude;
use App\Facades\Avatar;
use App\Models\InteractionLog;
use App\Services\PlayerHub\PlayerHubContextService;

class InteractionLogResource extends ModelResource
{
    public function toArray($request): array
    {
        /** @var InteractionLog $log */
        $log = $this->resource;
        $contextService = app(PlayerHubContextService::class);
        $contextService->activate($contextService->forClaim(
            $request->user(),
            (int) $log->entity_claim_id,
        ));
        $attitude = $log->getAttribute('attitude');

        return [
            'id' => $log->id,
            'player_session_id' => $log->player_session_id,
            'entity_id' => $log->entity_id,
            'entity' => [
                'name' => $log->entity->name,
                'image' => Avatar::campaign($log->entity->campaign)->entity($log->entity)->size(250)->fallback()->thumbnail(),
                'urls' => [
                    'show' => route('entities.show', [$log->entity->campaign, $log->entity]),
                ],
            ],
            'entity_claim_id' => $log->entity_claim_id,
            'note' => $log->note,
            'visibility' => $log->effectiveVisibility()->value,
            'attitude' => $attitude instanceof InteractionLogAttitude ? $attitude->value : null,
            'created_at' => $log->created_at,
            'updated_at' => $log->updated_at,
            'created_by' => $log->created_by,
        ];
    }
}
