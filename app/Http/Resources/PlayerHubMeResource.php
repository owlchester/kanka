<?php

namespace App\Http\Resources;

use App\Models\Entity;
use Illuminate\Http\Request;

class PlayerHubMeResource extends PlayerHubEntityDetailResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Entity $entity */
        $entity = $this->resource;

        return parent::toArray($request) + [
            'relations' => RelationResource::collection($entity->relationships)->resolve($request),
            'observations' => InteractionLogResource::collection($entity->getRelation('observations'))->resolve($request),
        ];
    }
}
