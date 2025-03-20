<?php

namespace App\Services\Api;

use App\Models\EntityType;
use App\Traits\EntityTypeAware;

class FilterService
{
    use EntityTypeAware;

    public function endpoints()
    {
        $endpoints = [];
        $types = EntityType::get();
        foreach ($types as $type) {
            $endpoints[] = [
                'code' => $type->code,
                'url' => url('/filters/' . $type->id),
            ];
        }

        return $endpoints;
    }

    public function filters(): array
    {
        $model = $this->entityType->getClass();
        if (method_exists($model, 'getFilterableColumns')) {
            return $model->getFilterableColumns();
        }

        return [];
    }
}
