<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Tag;
use App\Models\Timeline;
use App\Traits\CampaignAware;

class TimelineMapper
{
    use CampaignAware;
    use ImportMapper;
    use EntityMapper;

    protected array $ignore = ['id', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'timeline_id', 'created_at', 'updated_at', 'calendar_id'];

    public function first(): void
    {
        $this
            ->prepareModel(Timeline::class)
            ->trackMappings('timelines', 'timeline_id');
    }

    public function prepare(): self
    {
        $this->campaign->timelines()->forceDelete();
        return $this;
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (!isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this so it's going to be inefficient
            $timelines = Timeline::whereIn('id', $children)->get();
            /** @var Timeline $timeline */
            foreach ($timelines as $timeline) {
                $timeline->setParentId($this->mapping[$parent]);
                $timeline->save();
            }
        }

        return $this;
    }
}
