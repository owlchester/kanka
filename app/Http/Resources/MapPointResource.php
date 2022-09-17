<?php

namespace App\Http\Resources;

use App\Models\MapPoint;
use Illuminate\Http\Resources\Json\JsonResource;

class MapPointResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var MapPoint $model */
        $model = $this->resource;
        return [
            'target_entity_id' => $model->target_entity_id,
            'name' => $model->name,
            'axis_x' => $model->axis_x,
            'axis_y' => $model->axis_y,
            'colour' => $model->colour,
            'icon' => $model->icon,
            'shape' => $model->shape_id == MapPoint::SHAPE_CIRCLE ? 'circle' : 'square',
            'shape_id' => $model->shape_id,
            'size_id' => $model->size_id,
            'size' => $model->size(),

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
        ];
    }
}
