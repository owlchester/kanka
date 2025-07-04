<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Race;

class RaceMapper extends MiscMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'race_id', 'created_at', 'updated_at'];

    protected string $className = Race::class;

    protected string $mappingName = 'races';

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('race_id');
    }

    public function second(): void
    {
        $this->loadModel()
            ->pivot('pivotLocations', 'locations', 'location_id')
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
            $models = Race::whereIn('id', $children)->get();
            foreach ($models as $model) {
                $model->race_id = $this->mapping[$parent];
                $model->saveQuietly();
            }
        }

        return $this;
    }
}
