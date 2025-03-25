<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Facades\ImportIdMapper;
use App\Models\Timeline;
use App\Models\TimelineElement;
use App\Models\TimelineEra;

class TimelineMapper extends MiscMapper
{
    protected array $ignore = ['id', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'timeline_id', 'created_at', 'updated_at', 'calendar_id'];

    protected string $className = Timeline::class;

    protected string $mappingName = 'timelines';

    protected array $eras;

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('timeline_id');
    }

    public function second(): void
    {
        // @phpstan-ignore-next-line
        $this->loadModel()
            ->eras()
            ->elements()
            ->entitySecond();
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (! isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this so it's going to be inefficient
            $models = Timeline::whereIn('id', $children)->get();
            /** @var Timeline $model */
            foreach ($models as $model) {
                $model->timeline_id = $this->mapping[$parent];
                $model->saveQuietly();
            }
        }

        return $this;
    }

    protected function eras(): self
    {
        $fields = [
            'name', 'abbreviation', 'start_year', 'end_year', 'entry', 'is_collapsed', 'position',
        ];
        $this->eras = [];
        foreach ($this->data['eras'] as $data) {
            $er = new TimelineEra;
            $er->timeline_id = $this->model->id;
            foreach ($fields as $field) {
                $er->$field = $data[$field];
            }
            $er->entry = $this->mentions($er->entry);
            $er->save();
            $this->eras[$data['id']] = $er->id;
        }

        return $this;
    }

    protected function elements(): self
    {
        $fields = [
            'position', 'name', 'date', 'entry', 'colour', 'visibility_id', 'icon', 'is_collapsed', 'use_entity_entry', 'use_event_date',
        ];
        foreach ($this->data['elements'] as $data) {
            $el = new TimelineElement;
            $el->timeline_id = $this->model->id;
            $el->era_id = $this->eras[$data['era_id']];
            if (! empty($data['entity_id'])) {
                if (! ImportIdMapper::hasEntity($data['entity_id'])) {
                    continue;
                }
                $el->entity_id = ImportIdMapper::getEntity($data['entity_id']);
            }
            foreach ($fields as $field) {
                $el->$field = $data[$field];
            }
            $el->entry = $this->mentions($el->entry);
            $el->save();

            ImportIdMapper::putTimelineElement($data['id'], $el->id);
        }

        return $this;
    }
}
