<?php

namespace App\Http\Resources;

use App\Models\Organisation;
use Illuminate\Http\Request;

class OrganisationResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Organisation $model */
        $model = $this->resource;
        $locationIds = $model->entity->locations->pluck('id');

        return $this->entity([
            'members' => OrganisationMemberResource::collection($model->members()->has('character')->with('character')->get()),
            'locations' => $locationIds,
        ]);
    }
}
