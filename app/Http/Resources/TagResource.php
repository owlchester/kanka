<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends EntityResource
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
            'tag_id' => $this->tag_id,
            'colour' => $this->colour,
            'entities' => $this->entities()->distinct()->pluck('entities.id')->toArray(),
        ]);
    }
}
