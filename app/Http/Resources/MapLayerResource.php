<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MapLayerResource extends ModelResource
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
            'position' => (int) $this->position,
            'width' => $this->width,
            'height' => $this->height,
            'visibility' => $this->visibility
        ]);
    }
}
