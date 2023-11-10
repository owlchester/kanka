<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Family;
use App\Traits\CampaignAware;

class FamilyMapper
{
    use CampaignAware;
    use ImportMapper;
    use EntityMapper;

    protected array $ignore = ['id', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'family_id', 'created_at', 'updated_at'];

    public function first(): void
    {
        $this
            ->prepareModel(Family::class)
            ->trackMappings('families', 'family_id');
    }

    public function prepare(): self
    {
        $this->campaign->families()->forceDelete();
        return $this;
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (!isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this, so it's going to be inefficient
            $models = Family::whereIn('id', $children)->get();
            foreach ($models as $model) {
                $model->setParentId($this->mapping[$parent]);
                $model->save();
            }
        }

        return $this;
    }
}
