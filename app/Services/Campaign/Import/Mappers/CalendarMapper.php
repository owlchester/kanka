<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Calendar;
use App\Models\CalendarWeather;

class CalendarMapper extends StandardTreeMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'calendar_id', 'created_at', 'updated_at'];

    protected string $className = Calendar::class;

    protected string $mappingName = 'calendars';

    public function first(): void
    {
        foreach (['months', 'weekdays', 'years', 'eras', 'seasons', 'moons', 'week_names', 'month_aliases'] as $field) {
            if (! isset($this->data[$field]) || ! is_string($this->data[$field])) {
                continue;
            }

            $decoded = json_decode($this->data[$field], true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $this->data[$field] = $decoded;
            }
        }

        $this
            ->prepareModel()
            ->trackMappings('calendar_id');
    }

    public function second(): void
    {
        $this->loadModel()
            ->weather() // @phpstan-ignore method.notFound
            ->entitySecond();
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
}
