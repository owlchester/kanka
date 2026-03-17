<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Creature;
use App\Models\Entity;

class CreatureMapper extends MiscMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'creature_id', 'created_at', 'updated_at'];

    protected string $className = Creature::class;

    protected string $mappingName = 'creatures';

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('creature_id');
    }

    public function second(): void
    {
        $this->loadModel()
            ->entityLocations()
            ->saveModel()
            ->entitySecond();
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $entityIds) {
            if (! isset($this->mapping[$parent])) {
                continue;
            }
            $parentEntity = Entity::where('entity_id', $this->mapping[$parent])
                ->where('type_id', config('entities.ids.creature'))
                ->first();
            if (! $parentEntity) {
                continue;
            }
            $entities = Entity::whereIn('id', $entityIds)->get();
            foreach ($entities as $entity) {
                $entity->parent_id = $parentEntity->id;
                $entity->saveQuietly();
            }
        }

        return $this;
    }
}
