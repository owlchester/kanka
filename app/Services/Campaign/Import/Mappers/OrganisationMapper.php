<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Entity;
use App\Models\Organisation;

class OrganisationMapper extends MiscMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'organisation_id', 'created_at', 'updated_at', 'location_id'];

    protected string $className = Organisation::class;

    protected string $mappingName = 'organisations';

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('organisation_id');
    }

    public function second(): void
    {
        $this
            ->loadModel()
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
                ->where('type_id', config('entities.ids.organisation'))
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
