<?php

namespace App\Http\Resources;

use App\Models\Map;

class MapResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Map $model */
        $model = $this->resource;

        return $this->entity([
            'height' => $model->height,
            'width' => $model->width,
            'map_id' => $model->map_id,
            'grid' => $model->grid,
            'min_zoom' => $model->minZoom(),
            'max_zoom' => $model->maxZoom(),
            'initial_zoom' => $model->initialZoom(),
            'center_marker_id' => $model->center_marker_id,
            'center_x' => $model->center_x,
            'center_y' => $model->center_y,
            'layers' => MapLayerResource::collection($model->layers),
            'groups' => MapGroupResource::collection($model->groups),
            'is_real' => (bool) $model->is_real,
            'config' => $model->config,
        ]);
    }
}
