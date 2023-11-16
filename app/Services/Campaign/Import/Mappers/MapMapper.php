<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Tag;
use App\Models\Map;
use App\Traits\CampaignAware;

class MapMapper
{
    use CampaignAware;
    use ImportMapper;
    use EntityMapper;

    protected array $ignore = ['id', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'map_id', 'created_at', 'updated_at'];

    protected string $className = Map::class;
    protected string $mappingName = 'maps';

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('map_id');
    }

    public function prepare(): self
    {
        $this->campaign->maps()->forceDelete();
        return $this;
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (!isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this so it's going to be inefficient
            $maps = Map::whereIn('id', $children)->get();
            /** @var Map $map */
            foreach ($maps as $map) {
                $map->setParentId($this->mapping[$parent]);
                $map->save();
            }
        }

        return $this;
    }
}
