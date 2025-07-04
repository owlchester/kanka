<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Event;

class EventMapper extends MiscMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'event_id', 'created_at', 'updated_at'];

    protected string $className = Event::class;

    protected string $mappingName = 'events';

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('event_id');
    }

    public function second(): void
    {
        $this
            ->loadModel()
            ->foreign('locations', 'location_id')
            ->saveModel()
            ->entitySecond();
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (! isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this so it's going to be inefficient
            $models = Event::whereIn('id', $children)->get();
            foreach ($models as $model) {
                $model->event_id = $this->mapping[$parent];
                $model->saveQuietly();
            }
        }

        return $this;
    }
}
