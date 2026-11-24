<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Creature;

class CreatureMapper extends StandardTreeMapper
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
}
