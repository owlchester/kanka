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
            $link->date = $data['date'];
            $link->comment = Purify::clean($data['comment']);
            $link->is_recurring = $data['is_recurring'];
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
            $event->date = $data['date'];
            $event->save();
            return $event->entity;
        } elseif(!empty($data['entity_id'])) {
            return Entity::findOrFail($data['entity_id']);
        }

        return false;
    }
}