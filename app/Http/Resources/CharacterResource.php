<?php

namespace App\Http\Resources;

use App\Models\Character;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

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
        $raceID = Arr::first($raceIDs);

        $familyIDs = $model->families()->pluck('families.id');
        $familyID = Arr::first($familyIDs);

        $character = [
            'title' => $model->title,
            'age' => $model->age,
            'sex' => $model->sex,
            'pronouns' => $model->pronouns,
            'race_id' => $raceID,
            'races' => $raceIDs,
            'type' => $model->type,

            'family_id' => $familyID,
            'families' => $familyIDs,

            'is_dead' => (bool) $model->is_dead,
            'traits' => CharacterTraitResource::collection($model->characterTraits),
            'is_personality_visible' => (bool) $model->is_personality_visible,
        ];

        if (request()->get('related', false)) {
            $character['organisations'] = new CharacterOrganisationResource($model->organisations()->has('organisation')->get());
        }
        return $this->entity($character);
    }
}
