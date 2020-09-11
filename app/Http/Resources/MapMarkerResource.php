<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MapMarkerResource extends ModelResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->entity([
            'map_id' => $this->map_id,
            'name' => $this->name,
            'entity_id' => $this->entity_id,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'colour' => $this->colour,
            'font_colour' => $this->font_colour,
            'shape_id' => $this->shape_id,
            'size_id' => $this->size_id,
            'icon' => $this->icon,
            'custom_icon' => $this->custom_icon,
            'custom_shape' => $this->custom_shape,
            'is_draggable' => (bool) $this->is_draggable,
            'opacity' => $this->opacity,
            'visibility' => $this->visibility
        ]);
    }
}
