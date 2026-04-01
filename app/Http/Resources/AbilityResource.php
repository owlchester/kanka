<?php

namespace App\Http\Resources;

use App\Models\Ability;
use Illuminate\Http\Request;

class AbilityResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Ability $ability */
        $ability = $this->resource;

        return $this->entity([
            'charges' => $ability->charges,
            'abilities' => $ability->entity->descendants()->pluck('id')->toArray(),
        ]);
    }
}
