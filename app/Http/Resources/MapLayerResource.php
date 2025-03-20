<?php

namespace App\Http\Resources;

use App\Models\MapLayer;

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
        /** @var MapLayer $model */
        $model = $this->resource;

        return $this->entity([
            'map_id' => (int) $model->map_id,
            'name' => $model->name,
            'position' => (int) $model->position,
            'width' => (int) $model->width,
            'height' => (int) $model->height,
            'visibility_id' => $model->visibility_id,
            'type_id' => (bool) $model->type_id,
            'type' => (string) $model->typeName(),
        ]);
    }
}
