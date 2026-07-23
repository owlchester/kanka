<?php

namespace App\Http\Resources\Maps\Explore;

use App\Facades\Avatar;
use App\Models\Entity;
use App\Models\MapMarker;
use App\Traits\CampaignAware;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property MapMarker $resource
 */
class PinPreviewResource extends JsonResource
{
    use CampaignAware;

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
            'explore_maps' => $this->exploreMaps($entity),
        ];
    }

    /**
     * @return array<int, array{name: string, url: string}>
     */
    protected function exploreMaps(?Entity $entity): array
    {
        if (! $entity) {
            return [];
        }

        if ($entity->isMap()) {
            return [['name' => $entity->name, 'url' => route('entities.map', [$this->campaign->id, $entity->id])]];
        }

        if ($entity->isLocation() && $entity->child && ! $entity->child->maps->isEmpty()) {
            return $entity->child->maps
                ->map(fn ($map) => ['name' => $map->name, 'url' => route('entities.map', [$this->campaign->id, $map->entity->id])])
                ->all();
        }

        return [];
    }
}
