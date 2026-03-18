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
            'is_extinct' => $model->isExtinct(),
            'is_dead' => $model->isDead(),
            'locations' => $locationIds,
        ]);
    }
}
