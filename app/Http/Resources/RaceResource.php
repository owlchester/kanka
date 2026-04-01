<?php

namespace App\Http\Resources;

use App\Models\Race;
use Illuminate\Http\Request;

class RaceResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Race $model */
        $model = $this->resource;
        $locationIds = $model->entity->locations->pluck('id');

        return $this->entity([
            'is_extinct' => $model->isExtinct(),
            'locations' => $locationIds,
        ]);
    }
}
