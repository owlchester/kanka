<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return $this->entity([
            'system' => $this->system,
            'parameters' => $this->parameters,
            'rolls' => $this->diceRollResults()->pluck('results')->toArray()
        ]);
    }
}
