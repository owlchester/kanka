<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Quest extends EntityResource
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
            'type' => $this->type,
            'is_completed' => (bool) $this->is_completed,
            'quest_id' => $this->quest_id,
            'character_id' => $this->character_id,
            'characters' => $this->characters->count(),
            'locations' => $this->locations->count(),
        ]);
    }
}
