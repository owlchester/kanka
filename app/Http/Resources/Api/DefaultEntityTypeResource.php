<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class DefaultEntityTypeResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var \App\Models\EntityType $entityType */
        $entityType = $this->resource;

        return [
            'id' => $entityType->id,
            'code' => $entityType->code,
            'singular' => __('entities.' . $entityType->code),
            'plural' => __('entities.' . $entityType->pluralCode()),
            'icon' => $entityType->icon,
            'is_special' => false,
            'is_enabled' => true,
            'is_nested' => $entityType->isNested(),
            'has_table' => $entityType->hasTable(),
        ];
    }
}
