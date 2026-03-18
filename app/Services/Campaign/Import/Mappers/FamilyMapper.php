<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Entity;
use App\Models\Family;

class FamilyMapper extends MiscMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'family_id', 'created_at', 'updated_at', 'location_id'];

    protected string $className = Family::class;

    protected string $mappingName = 'families';

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('family_id');
    }

    public function second(): void
    {
        $this
            ->loadModel()
            ->foreign('locations', 'location_id')
            ->saveModel();

        /*$this
            ->familyTree();*/
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $entityIds) {
            if (! isset($this->mapping[$parent])) {
                continue;
            }
            $parentEntity = Entity::where('entity_id', $this->mapping[$parent])
                ->where('type_id', config('entities.ids.family'))
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
