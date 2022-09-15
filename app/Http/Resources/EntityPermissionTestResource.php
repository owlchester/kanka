<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EntityPermissionTestResource extends EntityChild
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
            'entity_type_id'    => $this['entity_type_id'],
            'entity_id'         => $this['entity_id'],
            'user_id'           => $this['user_id'],
            'action'            => $this['action'],
            'can'               => $this['can'],
        ];
    }
}
