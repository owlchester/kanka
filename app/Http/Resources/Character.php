<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Character extends EntityResource
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
            'title' => $this->title,
            'age' => $this->age,
            'sex' => $this->sex,
            'race' => $this->race,
            'type' => $this->type,

            'family_id' => $this->family_id,

            'is_dead' => (bool) $this->is_dead,
        ]);
    }
}
