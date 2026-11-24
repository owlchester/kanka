<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Location;

class LocationMapper extends StandardTreeMapper
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
}
