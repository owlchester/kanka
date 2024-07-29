<?php

namespace App\Http\Resources\Api\Entities;

use App\Facades\Avatar;
use App\Facades\Domain;
use App\Models\Entity;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class SlimEntityResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Entity $entity */
        $entity = $this->resource;

        $url = $entity->url();

        return [
            'id' => $entity->id,
            'name' => $entity->name,
            'type_id' => $entity->type_id,
            'child_id' => $entity->entity_id,
            'is_private' => (bool) $entity->is_private,
            'images' => [
                'thumbnail' => Avatar::entity($entity)->size(40)->thumbnail() ?: null,
                'original' => Avatar::entity($entity)->original() ?: null,
            ],
            'urls' => [
                'view' => $url,
                'api' => url('/1.0/campaigns/' . $entity->campaign_id . '/entities/' . $entity->id),
            ],
            'timestamps' => [
                'created_at' => $entity->created_at,
                'updated_at' => $entity->updated_at,
            ]
        ];
    }
}
