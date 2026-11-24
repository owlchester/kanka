<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Race;

class RaceMapper extends StandardTreeMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'race_id', 'created_at', 'updated_at'];

    protected string $className = Race::class;

    protected string $mappingName = 'races';

    public function first(): void
    {
        $this
            ->migrateOldStatus()
            ->prepareModel()
            ->trackMappings('race_id');
    }

    /**
     * Backward compatibility: resolve old boolean status fields to entities.status_id.
     */
    protected function migrateOldStatus(): self
    {
        if (array_key_exists('status_id', $this->data['entity'] ?? [])) {
            return $this;
        }

        if (! empty($this->data['is_extinct'])) {
            $this->resolveOldStatusToEntity('race', 'extinct');
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
}
