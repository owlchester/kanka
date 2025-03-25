<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Organisation;

class OrganisationMapper extends MiscMapper
{
    protected array $ignore = ['id', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'organisation_id', 'created_at', 'updated_at', 'location_id'];

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
            // We need the nested trait to trigger for this, so it's going to be inefficient
            $models = Organisation::whereIn('id', $children)->get();
            foreach ($models as $model) {
                $model->organisation_id = $this->mapping[$parent];
                $model->saveQuietly();
            }
        }

        return $this;
    }
}
