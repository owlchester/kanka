<?php

namespace App\Http\Resources;

use App\Models\CharacterTrait;

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
        /** @var CharacterTrait $resource */
        $resource = $this->resource;
        return [
            'id' => $resource->id,
            'name' => $resource->name,
            'entry' => $resource->entry,
            'section_id' => $resource->section_id,
            'section' => $resource->section_id == CharacterTrait::SECTION_APPEARANCE ? 'appearance' : 'personality',
            //'is_private' => (bool) $this->is_private,
            'default_order' => $resource->default_order,
        ];
    }
}
