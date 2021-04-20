<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestElementResource extends ModelResource
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
            'entity_id' => $this->entity_id,
            'description' => $this->description,
            'colour' => $this->colour,
            'role' => $this->role,
            'visibility' => $this->visibility,
        ]);
    }
}
