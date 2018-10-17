<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Tag extends EntityResource
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
            'tag_id' => $this->tag_id
        ]);
    }
}
