<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Calendar;
use App\Models\CalendarWeather;

class CalendarMapper extends MiscMapper
{
    protected array $ignore = ['id', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'calendar_id', 'created_at', 'updated_at'];

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
            ->entitySecond();
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (! isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this so it's going to be inefficient
            $models = Calendar::whereIn('id', $children)->get();
            foreach ($models as $model) {
                $model->calendar_id = $this->mapping[$parent];
                $model->saveQuietly();
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
                $el->$field = $data[$field];
            }
            $el->created_by = $this->user->id;
            $el->save();
        }

        return $this;
    }
}
