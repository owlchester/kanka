<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Ability;
use App\Models\Entity;

class AbilityMapper extends MiscMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'ability_id', 'created_at', 'updated_at'];

    protected string $className = Ability::class;

    protected string $mappingName = 'abilities';

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('ability_id');
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $entityIds) {
            if (! isset($this->mapping[$parent])) {
                continue;
            }
            $parentEntity = Entity::where('entity_id', $this->mapping[$parent])
                ->where('type_id', config('entities.ids.ability'))
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
