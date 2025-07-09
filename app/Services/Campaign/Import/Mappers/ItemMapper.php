<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Item;

class ItemMapper extends MiscMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'item_id', 'character_id', 'created_at', 'updated_at', 'location_id'];

    protected string $className = Item::class;

    protected string $mappingName = 'items';

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('item_id');
    }

    public function second(): void
    {
        $this
            ->loadModel()
            ->foreign('locations', 'location_id')
            ->foreign('entities', 'creator_id')
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
            $models = Item::whereIn('id', $children)->get();
            foreach ($models as $model) {
                $model->item_id = $this->mapping[$parent];
                $model->saveQuietly();
            }
        }

        return $this;
    }
}
