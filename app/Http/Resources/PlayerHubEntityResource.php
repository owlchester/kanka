<?php

namespace App\Http\Resources;

use App\Facades\Avatar;
use App\Models\Entity;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class PlayerHubEntityResource extends JsonResource
{
    use ApiSync;

    public function toArray($request): array
    {
        /** @var Entity $entity */
        $entity = $this->resource;
        $claim = $entity->claims->first();
        $lastPlayedSession = $claim?->lastPlayedSession;
        $entityType = $entity->entityType;
        $claimUrl = null;
        if ($claim === null && $entity->is_claimable) {
            $claimRoute = Route::has('api.player-hub.claim')
                ? 'api.player-hub.claim'
                : 'player-hub.claim';
            $claimUrl = route($claimRoute, $entity->id);
        }

        $data = [
            'id' => $entity->id,
            'name' => $entity->name,
            'type' => $entityType->code,
            'type_field' => $entity->type,
            'type_id' => $entity->type_id,
            'module' => [
                'id' => $entityType->id,
                'code' => $entityType->code,
                'singular' => $entityType->singular ?: __('entities.' . $entityType->code),
                'plural' => $entityType->plural ?: __('entities.' . $entityType->pluralCode()),
            ],
            'campaign' => [
                'id' => $entity->campaign_id,
                'name' => $entity->campaign->name,
                'url' => route('dashboard', $entity->campaign),
            ],
            'image' => Avatar::campaign($entity->campaign)->entity($entity)->size(250)->fallback()->thumbnail(),
            'is_claimable' => $entity->is_claimable,
            'status_id' => $entity->status_id,
            'created_at' => $entity->created_at,
            'created_by' => $entity->created_by,
            'updated_at' => $entity->updated_at,
            'updated_by' => $entity->updated_by,
            'urls' => [
                'view' => route('entities.show', [$entity->campaign, $entity]),
                'api' => route('campaigns.entities.show', [$entity->campaign_id, $entity->entity_id]),
                'claim' => $claimUrl,
            ],
            'parent_id' => $entity->parent_id,
        ];

        return $data + [
            'is_claimed' => $claim !== null,
            'claim' => $claim === null ? null : [
                'id' => $claim->id,
                'claimed_at' => $claim->claimed_at,
                'player_sessions_count' => (int) ($claim->player_sessions_count ?? 0),
                'interaction_entities_count' => (int) ($claim->interaction_entities_count ?? 0),
                'last_played_at' => $lastPlayedSession?->started_at,
            ],
        ];
    }
}
