<?php

namespace App\Http\Resources;

use App\Models\Character;

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
        /** @var Character $model */
        $model = $this->resource;

        // Fallback for old api calls
        // TODO: optimize to not re-do a db query
        $raceIDs = $model->races()->pluck('races.id');

        $familyIDs = $model->families()->pluck('families.id');

        $character = [
            'title' => $model->title,
            'age' => $model->age,
            'sex' => $model->sex,
            'pronouns' => $model->pronouns,
            'races' => $raceIDs,
            'type' => $model->type,

            'families' => $familyIDs,

            'is_dead' => (bool) $model->is_dead,
            'traits' => CharacterTraitResource::collection($model->characterTraits),
            'is_personality_visible' => (bool) $model->is_personality_visible,
            'is_personality_pinned' => (bool) $model->is_personality_pinned,
            'is_appearance_pinned' => (bool) $model->is_appearance_pinned,
        ];

        if (request()->get('related', false)) {
            $character['organisations'] = new CharacterOrganisationResource($model->organisationMemberships()->has('organisation')->get());
        }
        return $this->entity($character);
    }
}
