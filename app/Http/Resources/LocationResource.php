<?php

namespace App\Http\Resources;

use App\Models\Location;

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
            'location_id' => $model->location_id,
            'is_destroyed' => $model->isDestroyed()
        ]);
    }
}
