<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MapPoint extends JsonResource
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
            'target_id' => $this->target_id,
            'axis_x' => $this->axis_x,
            'axis_y' => $this->axis_y,
            'colour' => $this->colour,
            'name' => $this->name,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
