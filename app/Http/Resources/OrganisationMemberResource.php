<?php

namespace App\Http\Resources;

use App\Models\OrganisationMember;

class OrganisationMemberResource extends ModelResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var OrganisationMember $model */
        $model = $this->resource;

        return $this->entity([
            'role' => $model->role,
            'organisation_id' => $model->organisation_id,
            'character_id' => $model->character_id,
            'pin_id' => $model->pin_id,
            'status_id' => $model->status_id,
            'parent_id' => $model->parent_id,
        ]);
    }
}
