<?php

namespace App\Services;

use App\Models\Calendar;
use App\Models\CalendarEvent;
use App\Models\Event;
use Exception;

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
        $event = $this->event($data);
        if ($event) {
            $link = new CalendarEvent();
            $link->calendar_id = $calendar->id;
            $link->event_id = $event->id;
            $link->date = $data['date'];
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
    protected function event($data = [])
    {
        if (empty($data['event_id']) && !empty($data['name'])) {
            // Create an event
            $event = new Event();
            $event->name = $data['name'];
            $event->date = $data['date'];
            $event->save();
            return $event;
        } elseif(!empty($data['event_id'])) {
            return Event::findOrFail($data['event_id']);
        }

        return false;
    }
}