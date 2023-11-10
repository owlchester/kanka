<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Organisation;
use App\Traits\CampaignAware;

class OrganisationMapper
{
    use CampaignAware;
    use ImportMapper;
    use EntityMapper;

    protected array $ignore = ['id', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'organisation_id', 'created_at', 'updated_at'];

    public function first(): void
    {
        $this
            ->prepareModel(Organisation::class)
            ->trackMappings('organisations', 'organisation_id');
    }

    public function prepare(): self
    {
        $this->campaign->organisations()->forceDelete();
        return $this;
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (!isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this, so it's going to be inefficient
            $models = Organisation::whereIn('id', $children)->get();
            foreach ($models as $model) {
                $model->setParentId($this->mapping[$parent]);
                $model->save();
            }
        }

        return $this;
    }
}
