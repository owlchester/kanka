<?php

namespace App\Services;

use App\Exceptions\TranslatableException;
use App\Http\Requests\AddCalendarWeather;
use App\Models\Calendar;
use App\Models\CalendarWeather;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Event;
use App\Models\Reminder;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Arr;
use Stevebauman\Purify\Facades\Purify;

class CalendarService
{
    use CampaignAware;
    use UserAware;

    protected Calendar $calendar;

    public function calendar(Calendar $calendar): self
    {
        $this->calendar = $calendar;

        return $this;
    }

    /**
     * Add an event to a calendar, and return the new calendar_event model
     */
    public function addEvent(array $data = []): Reminder
    {
        $entity = $this->entity($data);
        $link = new Reminder;
        $link->remindable_type = Entity::class;
        $link->remindable_id = $entity->id;
        $link->calendar_id = $this->calendar->id;
        $link->year = $data['year'];
        $link->month = $data['month'];
        $link->day = $data['day'];
        $link->length = $data['length'];
        $link->comment = Purify::clean($data['comment']);
        $link->is_recurring = Arr::get($data, 'is_recurring', false);
        $link->colour = Arr::get($data, 'colour', null);
        $link->recurring_until = Arr::get($data, 'recurring_until', null);
        $link->recurring_periodicity = Arr::get($data, 'recurring_periodicity', null);
        $link->visibility_id = Arr::get($data, 'visibility_id', 1);
        $link->save();

        return $link;
    }

    /**
     * Save the weather on the requested date
     */
    public function saveWeather(AddCalendarWeather $request): CalendarWeather
    {
        // Make sure we don't already have a weather effect on this date
        $weather = $this->findWeather(
            (int) $request->post('year'),
            (int) $request->post('month'),
            (int) $request->post('day')
        );

        if (! $weather) {
            $weather = new CalendarWeather([
                'calendar_id' => $this->calendar->id,
                'year' => $request->post('year'),
                'month' => $request->post('month'),
                'day' => $request->post('day'),
                'visibility_id' => $request->post('visibility_id'),
                'name' => $request->post('name'),
            ]);
        }

        $weather->fill([
            'weather' => $request->post('weather'),
            'temperature' => $request->post('temperature'),
            'precipitation' => $request->post('precipitation'),
            'wind' => $request->post('wind'),
            'effect' => $request->post('effect'),
            'visibility_id' => $request->post('visibility_id'),
            'name' => $request->post('name'),
        ]);
        $weather->save();

        return $weather;
    }

    /**
     * Find the saved weather for a specific date
     */
    public function findWeather(int $year, int $month, int $day)
    {
        return CalendarWeather::dated(
            $this->calendar->id,
            $year,
            $month,
            $day
        )->first();
    }

    /**
     * Create a new event if it's just a name and no entity id. Otherwise, validate the entity
     *
     * @throws TranslatableException
     */
    protected function entity(array $data = []): Entity
    {
        if (empty($data['entity_id']) && ! empty($data['name'])) {
            $entityType = EntityType::find(config('entities.ids.event'));
            if (! $this->user->can('create', [$entityType, $this->campaign])) {
                throw new TranslatableException(__('calendars.event.errors.missing_permissions'));
            }
            // Create an event
            $event = new Event;
            $event->name = $data['name'];
            $event->date = $data['year'] . '-' . $data['month'] . '-' . $data['day'];
            $event->campaign_id = $this->campaign->id;
            if ($event->save()) {
                return $event->entity;
            }
        } elseif (! empty($data['entity_id'])) {
            return Entity::findOrFail($data['entity_id']);
        }

        throw new TranslatableException(__('calendars.event.errors.invalid_entity'));
    }
}
