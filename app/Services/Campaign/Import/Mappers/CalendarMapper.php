<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Calendar;
use App\Models\CalendarEra;
use App\Models\CalendarWeather;
use App\Models\Entity;

class CalendarMapper extends MiscMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'calendar_id', 'created_at', 'updated_at'];

    protected string $className = Calendar::class;

    protected string $mappingName = 'calendars';

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('calendar_id');
    }

    public function second(): void
    {
        // @phpstan-ignore-next-line
        $this->loadModel()
            ->weather()
            ->eras()
            ->entitySecond();
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $entityIds) {
            if (! isset($this->mapping[$parent])) {
                continue;
            }
            $parentEntity = Entity::where('entity_id', $this->mapping[$parent])
                ->where('type_id', config('entities.ids.calendar'))
                ->first();
            if (! $parentEntity) {
                continue;
            }
            $entities = Entity::whereIn('id', $entityIds)->get();
            foreach ($entities as $entity) {
                $entity->parent_id = $parentEntity->id;
                $entity->saveQuietly();
            }
        }

        return $this;
    }

    protected function weather(): self
    {
        if (empty($this->data['calendarWeather'])) {
            return $this;
        }
        $fields = [
            'weather', 'temperature', 'precipitation', 'wind', 'effect', 'name', 'day', 'month', 'year', 'visibility_id',
        ];
        foreach ($this->data['calendarWeather'] as $data) {
            $el = new CalendarWeather;
            $el->calendar_id = $this->model->id;
            foreach ($fields as $field) {
                if (! array_key_exists($field, $data)) {
                    continue;
                }
                $el->$field = $data[$field];
            }
            $el->created_by = $this->user->id;
            $el->save();
        }

        return $this;
    }

    protected function eras(): self
    {
        if (empty($this->data['calendarEras'])) {
            return $this;
        }
        $fields = [
            'name', 'description', 'colour', 'visibility_id',
            'start_day', 'start_month', 'start_year',
            'end_day', 'end_month', 'end_year',
            'show_era_dates',
        ];
        foreach ($this->data['calendarEras'] as $data) {
            $el = new CalendarEra;
            $el->calendar_id = $this->model->id;
            foreach ($fields as $field) {
                if (! array_key_exists($field, $data)) {
                    continue;
                }
                $el->$field = $data[$field];
            }
            $el->created_by = $this->user->id;
            $el->save();
        }

        return $this;
    }
}
