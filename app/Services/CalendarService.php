<?php

namespace App\Services;

use App\Http\Requests\AddCalendarWeather;
use App\Models\Calendar;
use App\Models\CalendarEvent;
use App\Models\CalendarWeather;
use App\Models\Entity;
use App\Models\EntityEvent;
use App\Models\Event;
use App\Observers\PurifiableTrait;
use Exception;
use Illuminate\Support\Arr;
use Stevebauman\Purify\Facades\Purify;

class CalendarService
{
    /**
     * Add an event to a calendar, and return the new calendar_event model
     * @param Calendar $calendar
     * @param array $data
     * @return CalendarEvent
     */
    public function addEvent(Calendar $calendar, $data = [])
    {
        $entity = $this->entity($data);
        if ($entity) {
            $link = new EntityEvent();
            $link->calendar_id = $calendar->id;
            $link->entity_id = $entity->id;
            $link->year = $data['year'];
            $link->month = $data['month'];
            $link->day = $data['day'];
            $link->length = $data['length'];
            $link->comment = Purify::clean($data['comment']);
            $link->is_recurring = Arr::get($data, 'is_recurring', false);
            $link->colour = Arr::get($data, 'colour', null);
            $link->recurring_until = Arr::get($data, 'recurring_until', null);
            $link->recurring_periodicity = Arr::get($data, 'recurring_periodicity', null);
            if ($link->save()) {
                return $link;
            }
        }
        return false;
    }

    /**
     * @param Calendar $calendar
     * @param AddCalendarWeather $request
     * @return CalendarWeather
     */
    public function saveWeather(Calendar $calendar, AddCalendarWeather $request): CalendarWeather
    {
        // Make sure we don't already have a weather effect on this date
        $weather = $this->findWeather(
            $calendar,
            $request->post('year'),
            $request->post('month'),
            $request->post('day')
        );

        if (!$weather) {
            $weather = new CalendarWeather([
                'calendar_id' => $calendar->id,
                'year' => $request->post('year'),
                'month' => $request->post('month'),
                'day' => $request->post('day'),
                'visibility' => $request->post('visibility'),
            ]);
        }

        $weather->fill([
            'weather' => $request->post('weather'),
            'temperature' => $request->post('temperature'),
            'precipitation' => $request->post('precipitation'),
            'wind' => $request->post('wind'),
            'effect' => $request->post('effect'),
            'visibility' => $request->post('visibility'),
        ]);
        $weather->save();

        return $weather;
    }

    /**
     * @param Calendar $calendar
     * @param int $year
     * @param int $month
     * @param int $day
     * @return mixed
     */
    public function findWeather(Calendar $calendar, int $year, int $month, int $day)
    {
        return CalendarWeather::dated(
            $calendar->id,
            $year,
            $month,
            $day
        )->first();
    }

    /**
     * @param array $data
     * @return Event
     * @throws Exception
     */
    protected function entity($data = [])
    {
        if (empty($data['entity_id']) && !empty($data['name'])) {
            // Create an event
            $event = new Event();
            $event->name = $data['name'];
            $event->date = $data['year'] . '-' . $data['month'] . '-' . $data['day'];
            if ($event->save()) {
                return $event->entity;
            }
        } elseif (!empty($data['entity_id'])) {
            return Entity::findOrFail($data['entity_id']);
        }

        return false;
    }
}
