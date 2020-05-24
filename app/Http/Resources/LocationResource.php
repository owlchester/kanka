<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends EntityResource
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
            'type' => $this->type,
            'map' => $this->getImageUrl(0, 0, 'map'),
            'is_map_private' => $this->is_map_private,
            'parent_location_id' => $this->parent_location_id,
        ]);
    }
}
