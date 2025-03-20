<?php

namespace App\Http\Resources;

use App\Models\MapGroup;

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
        /** @var MapGroup $model */
        $model = $this->resource;

        return $this->entity([
            'map_id' => $model->map_id,
            'name' => $model->name,
            'position' => (int) $model->position,
            'visibility_id' => $model->visibility_id,
            'is_shown' => (bool) $model->is_shown,
        ]);
    }
}
