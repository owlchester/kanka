<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AbilityResource extends EntityResource
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
            'type' => $this->type,
            'ability_id' => $this->ability_id,
            'charges' => $this->charges,
            'abilities' => $this->descendants()->pluck('id')->toArray()
        ]);
    }
}
