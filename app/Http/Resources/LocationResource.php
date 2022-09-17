<?php

namespace App\Http\Resources;

use App\Models\Location;
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
        /** @var Location $model */
        $model = $this->resource;
        return $this->entity([
            'type' => $model->type,
            'map' => $model->getImageUrl(0, 0, 'map'),
            'is_map_private' => $model->is_map_private,
            'parent_location_id' => $model->parent_location_id,
        ]);
    }
}
