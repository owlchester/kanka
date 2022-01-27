<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class EntityAliasResource extends EntityChild
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
            'name' => $this->name,
            'visibility_id' => $this->visibility_id,
        ]);
    }
}
