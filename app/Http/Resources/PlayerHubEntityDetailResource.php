<?php

namespace App\Http\Resources;

use App\Facades\Avatar;
use App\Models\Character;
use App\Models\Entity;
use App\Models\OrganisationMember;
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

        return [
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
            'organisations' => $this->organisations($character),
            'families' => $character?->characterFamilies
                ->filter(fn ($membership): bool => ! (bool) $membership->is_private)
                ->map(fn ($membership) => $this->summary($membership->family?->entity))
                ->filter()
                ->values()
                ->all() ?? [],
            'urls' => [
                'view' => route('entities.show', [$entity->campaign_id, $entity]),
                'api' => route(Route::has('api.player-hub.entities.show')
                    ? 'api.player-hub.entities.show'
                    : 'player-hub.entities.show', [
                        'entity' => $entity->id,
                        'entity_claim_id' => $request->integer('entity_claim_id'),
                    ]),
            ],
            'created_at' => $entity->created_at,
            'created_by' => $entity->created_by,
            'updated_at' => $entity->updated_at,
            'updated_by' => $entity->updated_by,
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function organisations(?Character $character): array
    {
        if ($character === null) {
            return [];
        }

        return $character->organisationMemberships
            ->filter(fn (OrganisationMember $membership): bool => ! (bool) $membership->is_private)
            ->map(function (OrganisationMember $membership): ?array {
                $summary = $this->summary($membership->organisation?->entity);
                if ($summary === null) {
                    return null;
                }

                return $summary + ['role' => $membership->role];
            })
            ->filter()
            ->values()
            ->all();
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
