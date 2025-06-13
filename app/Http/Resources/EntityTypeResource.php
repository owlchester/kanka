<?php

namespace App\Http\Resources;

use App\Models\EntityType;
use Illuminate\Http\Resources\Json\JsonResource;

class EntityTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var EntityType $this */
        return [
            'id' => $this->id,
            'code' => $this->code,
            'singular' => $this->name(),
            'plural' => $this->plural(),
            'icon' => $this->icon,
            'is_special' => $this->isCustom(),
            'is_enabled' => $this->isEnabled(),
            'is_nested' => $this->isNested(),
            'has_table' => $this->hasTable(),
        ];
    }
}
