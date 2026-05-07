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
            ->migrateOldStatus()
            ->prepareModel()
            ->trackMappings('creature_id');
    }

    /**
     * Backward compatibility: resolve old boolean status fields to entities.status_id.
     */
    protected function migrateOldStatus(): self
    {
        if (array_key_exists('status_id', $this->data['entity'] ?? [])) {
            return $this;
        }

        if (! empty($this->data['is_dead'])) {
            $this->resolveOldStatusToEntity('creature', 'dead');
        } elseif (! empty($this->data['is_extinct'])) {
            $this->resolveOldStatusToEntity('creature', 'extinct');
        }

        return $this;
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
