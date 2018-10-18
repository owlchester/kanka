<?php

namespace App\Services;

use App\Models\Calendar;
use App\Models\CalendarEvent;
use App\Models\Entity;
use App\Models\EntityEvent;
use App\Models\Event;
use App\Observers\PurifiableTrait;
use Exception;
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
            $link->date = $data['year'] . '-' . $data['month'] . '-' . $data['day'];
            $link->length = $data['length'];
            $link->comment = Purify::clean($data['comment']);
            $link->is_recurring = array_get($data, 'is_recurring', false);
            $link->colour = array_get($data, 'colour', null);
            $link->recurring_until = array_get($data, 'recurring_until', null);
            if ($link->save()) {
                return $link;
            }
        }
        return false;
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
