<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Creature;

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
        foreach ($this->parents as $parent => $children) {
            if (! isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this so it's going to be inefficient
            $models = Creature::whereIn('id', $children)->get();
            foreach ($models as $model) {
                $model->creature_id = $this->mapping[$parent];
                $model->saveQuietly();
            }
        }

        return $this;
    }
}
