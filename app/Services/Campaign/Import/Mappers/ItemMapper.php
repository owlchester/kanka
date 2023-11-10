<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Item;
use App\Traits\CampaignAware;

class ItemMapper
{
    use CampaignAware;
    use ImportMapper;
    use EntityMapper;

    protected array $ignore = ['id', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'item_id', 'created_at', 'updated_at'];

    public function first(): void
    {
        $this
            ->prepareModel(Item::class)
            ->trackMappings('items', 'item_id');
    }

    public function prepare(): self
    {
        $this->campaign->items()->forceDelete();
        return $this;
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (!isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this, so it's going to be inefficient
            $models = Item::whereIn('id', $children)->get();
            foreach ($models as $model) {
                $model->item_id = $this->mapping[$parent];
                $model->save();
            }
        }

        return $this;
    }
}
