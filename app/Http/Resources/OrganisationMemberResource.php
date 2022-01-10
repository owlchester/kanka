<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return $this->entity([
            'role' => $this->role,
            'organisation_id' => $this->organisation_id,
            'pin_id' => $this->pin_id,
            'status_id' => $this->status_id,
            'parent_id' => $this->parent_id,
        ]);
    }
}
