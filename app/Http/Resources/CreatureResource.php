<?php

namespace App\Http\Resources;

use App\Models\Creature;

class CreatureResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Creature $model */
        $model = $this->resource;
        $locationIDs = $model->locations()->pluck('locations.id');

        return $this->entity([
            'creature_id' => $model->creature_id,
            'is_extinct' => $model->isExtinct(),
            'is_dead' => $model->isDead(),
            'locations' => $locationIDs,
        ]);
    }
}
