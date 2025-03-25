<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Family;

class FamilyMapper extends MiscMapper
{
    protected array $ignore = ['id', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'family_id', 'created_at', 'updated_at', 'location_id'];

    protected string $className = Family::class;

    protected string $mappingName = 'families';

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('family_id');
    }

    public function second(): void
    {
        $this
            ->loadModel()
            ->foreign('locations', 'location_id')
            ->saveModel();

        /*$this
            ->familyTree();*/
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (! isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this, so it's going to be inefficient
            $models = Family::whereIn('id', $children)->get();
            foreach ($models as $model) {
                $model->family_id = $this->mapping[$parent];
                $model->saveQuietly();
            }
        }

        return $this;
    }
}
