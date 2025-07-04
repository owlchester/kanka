<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Ability;

class AbilityMapper extends MiscMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'ability_id', 'created_at', 'updated_at'];

    protected string $className = Ability::class;

    protected string $mappingName = 'abilities';

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('ability_id');
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (! isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this, so it's going to be inefficient
            $models = Ability::whereIn('id', $children)->get();
            foreach ($models as $model) {
                $model->ability_id = $this->mapping[$parent];
                $model->saveQuietly();
            }
        }

        return $this;
    }
}
