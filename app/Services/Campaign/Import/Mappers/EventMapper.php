<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Event;
use App\Traits\CampaignAware;

class EventMapper
{
    use CampaignAware;
    use ImportMapper;
    use EntityMapper;

    protected array $ignore = ['id', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'event_id', 'created_at', 'updated_at'];

    public function first(): void
    {
        $this
            ->prepareModel(Event::class)
            ->trackMappings('events', 'event_id');
    }

    public function prepare(): self
    {
        $this->campaign->events()->forceDelete();
        return $this;
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (!isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this so it's going to be inefficient
            $models = Event::whereIn('id', $children)->get();
            foreach ($models as $model) {
                $model->setParentId($this->mapping[$parent]);
                $model->save();
            }
        }

        return $this;
    }
}
