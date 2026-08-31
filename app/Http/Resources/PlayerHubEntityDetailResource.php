<?php

namespace App\Http\Resources;

use App\Facades\Avatar;
use App\Models\Entity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class PlayerHubEntityDetailResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Entity $entity */
        $entity = $this->resource;
        $character = $entity->entityType->code === 'character'
            ? $entity->character
            : null;

        $data = [
            'id' => $entity->id,
            'name' => $entity->name,
            'role' => $entity->type,
            'type' => $entity->entityType->code,
            'type_id' => $entity->type_id,
            'entry' => $entity->entry,
            'entry_parsed' => $entity->hasEntry() ? $entity->parsedEntry() : null,
            'tooltip' => $entity->tooltip,
            'image' => Avatar::entity($entity)->size(250)->fallback()->thumbnail(),
            'image_full' => Avatar::entity($entity)->original(),
            'is_private' => $entity->is_private,
            'status_id' => $entity->status_id,
            'campaign_id' => $entity->campaign_id,
            'locations' => $entity->locations
                ->map(fn ($location) => $this->summary($location->entity))
                ->filter()
                ->values()
                ->all(),
            'urls' => [
                'view' => route('entities.show', [$entity->campaign_id, $entity]),
                'api' => route(Route::has('api.player-hub.entities.show')
                    ? 'api.player-hub.entities.show'
                    : 'player-hub.entities.show', [
                        'entity' => $entity->id,
                        'entity_claim_id' => $request->integer('entity_claim_id') ?: $request->integer('claim_id'),
                    ]),
            ],
            'created_at' => $entity->created_at,
            'created_by' => $entity->created_by,
            'updated_at' => $entity->updated_at,
            'updated_by' => $entity->updated_by,
        ];

        if ($character !== null) {
            $data['races'] = $character->races
                ->map(fn ($race) => $this->summary($race->entity))
                ->filter()
                ->values()
                ->all();
            $data['families'] = $character->families
                ->map(fn ($family) => $this->summary($family->entity))
                ->filter()
                ->values()
                ->all();
            $data['organisations'] = $character->organisations
                ->map(fn ($organisation) => $this->summary($organisation->entity))
                ->filter()
                ->values()
                ->all();
        }

        return $data;
    }

    /**
     * @return array<string, mixed>|null
     */
    protected function summary(?Entity $entity): ?array
    {
        if ($entity === null) {
            return null;
        }

        return [
            'id' => $entity->id,
            'name' => $entity->name,
            'url' => route('entities.show', [$entity->campaign_id, $entity]),
        ];
    }
}
