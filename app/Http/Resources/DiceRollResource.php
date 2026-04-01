<?php

namespace App\Http\Resources;

use App\Models\DiceRoll;
use Illuminate\Http\Request;

class DiceRollResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
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
