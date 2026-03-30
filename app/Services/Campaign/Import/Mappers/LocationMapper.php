<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Entity;
use App\Models\Location;

class LocationMapper extends MiscMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'location_id', 'created_at', 'updated_at'];

    protected string $className = Location::class;

    protected string $mappingName = 'locations';

    public function first(): void
    {
        $this
            ->migrateOldStatus()
            ->prepareModel()
            ->trackMappings('location_id');
    }

    /**
     * Backward compatibility: resolve old boolean status fields to entities.status_id.
     */
    protected function migrateOldStatus(): self
    {
        if (array_key_exists('status_id', $this->data['entity'] ?? [])) {
            return $this;
        }

        if (! empty($this->data['is_destroyed'])) {
            $this->resolveOldStatusToEntity('location', 'destroyed');
        }

        return $this;
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $entityIds) {
            if (! isset($this->mapping[$parent])) {
                continue;
            }
            $parentEntity = Entity::where('entity_id', $this->mapping[$parent])
                ->where('type_id', config('entities.ids.location'))
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
