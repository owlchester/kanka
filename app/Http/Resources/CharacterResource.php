<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CharacterResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $character = [
            'title' => $this->title,
            'age' => $this->age,
            'sex' => $this->sex,
            'race_id' => $this->race_id,
            'type' => $this->type,

            'family_id' => $this->family_id,

            'is_dead' => (bool) $this->is_dead,
            'traits' => CharacterTraitResource::collection($this->characterTraits),
            'is_personality_visible' => (bool) $this->is_personality_visible,
        ];

        if (request()->get('related', false)) {
            $character['organisations'] = new CharacterOrganisationResource($this->organisations()->has('organisation')->get());
        }
        return $this->entity($character);
    }
}
