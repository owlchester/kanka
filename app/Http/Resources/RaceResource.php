<?php

namespace App\Http\Resources;

use App\Models\Race;

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
        $locationIds = $model->entity->locations->pluck('id');

        return $this->entity([
            'race_id' => $model->race_id,
            'is_extinct' => $model->isExtinct(),
            'locations' => $locationIds,
        ]);
    }
}
