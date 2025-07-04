<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Location;

class LocationMapper extends MiscMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'location_id', 'created_at', 'updated_at'];

    protected string $className = Location::class;

    protected string $mappingName = 'locations';

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('location_id');
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (! isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this so it's going to be inefficient
            $locations = Location::whereIn('id', $children)->get();
            /** @var Location $model */
            foreach ($locations as $model) {
                $model->location_id = $this->mapping[$parent];
                $model->saveQuietly();
            }
        }

        return $this;
    }
}
