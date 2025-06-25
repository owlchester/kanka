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
        /** @var \App\Models\EntityType $entityType */
        $entityType = $this->resource;

        return [
            'id' => $entityType->id,
            'code' => $entityType->code,
            'singular' => $entityType->name(),
            'plural' => $entityType->plural(),
            'icon' => $entityType->icon,
            'is_special' => $entityType->isCustom(),
            'is_enabled' => $entityType->isEnabled(),
            'is_nested' => $entityType->isNested(),
            'has_table' => $entityType->hasTable(),
        ];
    }
}
