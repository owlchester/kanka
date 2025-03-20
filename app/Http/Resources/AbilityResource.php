<?php

namespace App\Http\Resources;

use App\Models\Ability;

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
        /** @var Ability $ability */
        $ability = $this->resource;

        return $this->entity([
            'ability_id' => $ability->ability_id,
            'charges' => $ability->charges,
            'abilities' => $ability->descendants()->pluck('id')->toArray(),
        ]);
    }
}
