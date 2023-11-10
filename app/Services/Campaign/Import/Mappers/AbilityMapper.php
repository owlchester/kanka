<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Ability;
use App\Traits\CampaignAware;

class AbilityMapper
{
    use CampaignAware;
    use ImportMapper;
    use EntityMapper;

    protected array $ignore = ['id', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'ability_id', 'created_at', 'updated_at'];

    public function first(): void
    {
        $this
            ->prepareModel(Ability::class)
            ->trackMappings('abilities', 'ability_id');
    }

    public function prepare(): self
    {
        $this->campaign->abilities()->forceDelete();
        return $this;
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (!isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this, so it's going to be inefficient
            $models = Ability::whereIn('id', $children)->get();
            foreach ($models as $model) {
                $model->setParentId($this->mapping[$parent]);
                $model->save();
            }
        }

        return $this;
    }
}
