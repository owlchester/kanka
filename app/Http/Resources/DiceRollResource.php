<?php

namespace App\Http\Resources;

use App\Models\DiceRoll;

class DiceRollResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var DiceRoll $model */
        $model = $this->resource;

        return $this->entity([
            'system' => $model->system,
            'parameters' => $model->parameters,
            'rolls' => $model->diceRollResults()->pluck('results')->toArray(),
        ]);
    }
}
