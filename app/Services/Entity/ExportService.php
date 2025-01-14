<?php

namespace App\Services\Entity;

use App\Http\Resources\EntityResource;
use App\Models\Entity;
use Illuminate\Support\Str;

class ExportService
{
    /** @var Entity */
    protected $entity;

    /**
     * @return $this
     */
    public function entity(Entity $entity): self
    {
        $this->entity = $entity;
        return $this;
    }

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
        } elseif ($this->entity->entityType->isSpecial()) {
            return new EntityResource($this->entity);
        } else {
            return ['error' => 'unknown resource ' . $className];
        }
    }
}
