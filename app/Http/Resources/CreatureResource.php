<?php

namespace App\Http\Resources;

use App\Models\Creature;
use Illuminate\Http\Request;

class CreatureResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Creature $model */
        $model = $this->resource;
        $locationIds = $model->entity->locations->pluck('id');

        return $this->entity([
            'creature_id' => $model->creature_id,
            'is_extinct' => $model->isExtinct(),
            'is_dead' => $model->isDead(),
            'locations' => $locationIds,
        ]);
    }
}
