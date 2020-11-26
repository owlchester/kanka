<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestOrganisationResource extends ModelResource
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
            'organisation_id' => $this->organisation_id,
            'description' => $this->description,
            'role' => $this->role,
        ]);
    }
}
