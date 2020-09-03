<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RelationResource extends JsonResource
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
            'owner_id' => $this->owner_id,
            'target_id' => $this->target_id,
            'relation' => $this->relation,
            'attitude' => $this->attitude,
            'colour' => $this->colour,
            'is_private' => (bool) $this->is_private,
            'is_star' => (bool) $this->is_star,
            'mirror_id' => $this->mirror_id,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
