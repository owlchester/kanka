<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Relation extends JsonResource
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
            'owner_id' => $this->owner_id,
            'target_id' => $this->target_id,
            'relation' => $this->relation,
            'is_private' => (bool) $this->is_private,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
