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
        return [
            'target_entity_id' => $this->target_entity_id,
            'name' => $this->name,
            'axis_x' => $this->axis_x,
            'axis_y' => $this->axis_y,
            'colour' => $this->colour,
            'icon' => $this->icon,
            'shape' => $this->shape_id == MapPoint::SHAPE_CIRCLE ? 'circle' : 'square',
            'shape_id' => $this->shape_id,
            'size_id' => $this->size_id,
            'size' => $this->size(),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
