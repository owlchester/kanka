<?php

namespace App\Http\Resources;

use App\Models\CharacterTrait;
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
            'section_id' => $this->section_id,
            'section' => $this->section_id == CharacterTrait::SECTION_APPEARANCE ? 'appearance' : 'personality',
            //'is_private' => (bool) $this->is_private,
            'default_order' => $this->default_order,
        ];
    }
}
