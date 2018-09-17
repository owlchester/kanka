<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Attribute extends EntityChild
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
            'value' => $this->value,
            'default_order' => $this->default_order,
        ]);
    }
}
