<?php

namespace App\Http\Resources;

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
            'visibility_id' => $this->visibility_id,
            'is_shown' => (bool) $this->is_shown,
        ]);
    }
}
