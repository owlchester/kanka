<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MapGroupResource extends ModelResource
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
            'visibility' => $this->visibility,
            'is_shown' => (bool) $this->is_shown,
        ]);
    }
}
