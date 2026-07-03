<?php

namespace App\Http\Resources\Maps\Explore;

use App\Models\MapMarker;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property MapMarker $resource
 */
class PinResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $marker = $this->resource;

        return [
            'id' => $marker->id,
            'name' => $marker->name ?: ($marker->entity->name ?? ''),
            'group_id' => $marker->group_id,
            'latitude' => (float) $marker->latitude,
            'longitude' => (float) $marker->longitude,
            'shape' => $marker->shape_id?->name ?? 'marker',
            'colour' => $marker->colour,
            'font_colour' => $marker->font_colour,
            'icon' => $marker->exploreIcon(),
            'size_id' => $marker->size_id,
            'pin_size' => $marker->pin_size,
            'circle_radius' => $marker->circle_radius,
            'opacity' => (float) ($marker->opacity ?: 100),
        ];
    }
}
