<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CharacterTraitResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'entry' => $this->entry,
            'section' => $this->section,
            'is_private' => (bool) $this->is_private,
            'default_order' => $this->default_order,
        ];
    }
}
