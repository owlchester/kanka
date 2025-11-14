<?php

namespace App\Services\Entity;

use App\Http\Resources\EntityResource;
use App\Traits\EntityAware;
use Illuminate\Support\Str;

class ExportService
{
    use EntityAware;

    /**
     * @return array|mixed
     */
    public function json()
    {
        $child = Str::studly($this->entity->entityType->code);
        $className = 'App\Http\Resources\\' . $child . 'Resource';

        if (class_exists($className)) {
            $resource = new $className($this->entity->child);

            return $resource->withRelated();
        } elseif ($this->entity->entityType->isCustom()) {
            return new EntityResource($this->entity);
        } else {
            return ['error' => 'unknown resource ' . $className];
        }
    }
}
