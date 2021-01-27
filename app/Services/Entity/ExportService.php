<?php


namespace App\Services\Entity;


use App\Models\Entity;
use Illuminate\Support\Str;

class ExportService
{
    /** @var Entity */
    protected $entity;

    /**
     * @param Entity $entity
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
        $child = Str::studly($this->entity->type);
        $className = 'App\Http\Resources\\' . $child . 'Resource';

        if (class_exists($className)) {
            $resource = new $className($this->entity->child);
            return $resource->withRelated();
        } else {
            return ['error' => 'unknown resource ' . $className];
        }
    }
}
