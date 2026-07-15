<?php

namespace App\Http\Resources\Maps\Explore;

use App\Facades\Avatar;
use App\Models\MapMarker;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property MapMarker $resource
 */
class PinPreviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $marker = $this->resource;
        $entity = $marker->entity;
        $canEdit = auth()->check() && auth()->user()->can('update', $marker->map->entity);

        return [
            'entity_name' => $entity?->name,
            'entity_url' => $entity?->url(),
            'entity_image' => $entity && $entity->hasImage() ? Avatar::entity($entity)->size(400, 200)->thumbnail() : null,
            'marker_entry' => $marker->hasEntry() ? $marker->parsedEntry() : null,
            'entity_entry' => $entity && $entity->hasEntry() ? $entity->parsedEntry() : null,
            'type' => $marker->typeLabel(),
            'group_name' => $marker->group?->name,
            'group_colour' => $marker->group?->colour,
            'can_edit' => $canEdit,
        ];
    }
}
