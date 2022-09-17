<?php

namespace App\Http\Resources;

use App\Models\Race;
use Illuminate\Http\Resources\Json\JsonResource;

class RaceResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Race $model */
        $model = $this->resource;
        $locationIDs = $model->locations()->pluck('locations.id');

        return $this->entity([
            'type' => $model->type,
            'race_id' => $model->race_id,
            'locations' => $locationIDs
        ]);
    }
}
