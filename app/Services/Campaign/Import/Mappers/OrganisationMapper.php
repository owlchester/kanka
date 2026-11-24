<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Organisation;

class OrganisationMapper extends StandardTreeMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'organisation_id', 'created_at', 'updated_at', 'location_id'];

    protected string $className = Organisation::class;

    protected string $mappingName = 'organisations';

    public function first(): void
    {
        $this
            ->migrateOldStatus()
            ->prepareModel()
            ->trackMappings('organisation_id');
    }

    /**
     * Backward compatibility: resolve old boolean status fields to entities.status_id.
     */
    protected function migrateOldStatus(): self
    {
        if (array_key_exists('status_id', $this->data['entity'] ?? [])) {
            return $this;
        }

        if (! empty($this->data['is_defunct'])) {
            $this->resolveOldStatusToEntity('organisation', 'defunct');
        }

        return $this;
    }

    public function second(): void
    {
        $this
            ->loadModel()
            ->entityLocations()
            ->saveModel()
            ->entitySecond();
    }
}
