<?php

namespace App\Http\Resources;

use App\Models\Organisation;

class OrganisationResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Organisation $model */
        $model = $this->resource;
        $locationIds = $model->entity->locations->pluck('id');

        return $this->entity([
            'organisation_id' => $model->organisation_id,
            'is_defunct' => $model->isDefunct(),
            'members' => OrganisationMemberResource::collection($model->members()->has('character')->with('character')->get()),
            'locations' => $locationIds,
        ]);
    }
}
