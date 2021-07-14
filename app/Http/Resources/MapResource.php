<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Map;
use App\Models\MapMarker;

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
        /** @var Character $model */
        $model = $this->resource;

        return $this->entity([
            'type' => $model->type,
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
        ]);
    }
}
