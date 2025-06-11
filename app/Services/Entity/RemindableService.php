<?php

namespace App\Services\Entity;

use App\Models\Calendar;
use App\Models\Entity;
use App\Models\EntityEventType;
use App\Models\Post;
use App\Models\Reminder;
use App\Traits\RequestAware;
use Exception;

class RemindableService
{
    use RequestAware;

    public function save(Post|Entity $model)
    {

        // The user is editing an entity with a calendar, but doesn't have the permission to see
        // the calendar? We skip any work.
        if ($this->request->has('calendar_skip')) {
            return;
        }

        // Previously, this lookup was only triggered when the calendar_id or date was dirty. However, this excludes just
        // changing the colour or periodicity. To support the API not overriding the values, we still check to make
        // sure that the calendar_id property is set.
        if (! $this->request->has('calendar_id')) {
            return;
        }

        $calendarID = $this->request->post('calendar_id');

        // We already had this event linked
        $reminder = $model->calendarReminder();

        if ($reminder !== null) {
            // We no longer have a calendar attached to this model
            if ($calendarID === null) {
                $reminder->delete();

                return;
            }
        } else {
            $reminder = new Reminder;
            if ($model instanceof Post) {
                $reminder->remindable_type = Post::class;
                $reminder->remindable_id = $model->id;
            } else {
                $reminder->remindable_type = Entity::class;
                $reminder->remindable_id = $model->id;
            }
        }

        // Validate the calendar
        /** @var ?Calendar $calendar */
        $calendar = Calendar::find($calendarID);

        if ($calendar === null || $calendar->missingDetails()) {
            return;
        }

        $length = $this->request->post('calendar_length', '1');
        $length = max(1, $length);
        $reminder->calendar_id = $this->request->get('calendar_id');
        $reminder->year = (int) $this->request->post('calendar_year', '1');
        $reminder->month = (int) $this->request->post('calendar_month', '1');
        $reminder->day = (int) $this->request->post('calendar_day', '1');
        $reminder->length = $length;
        $reminder->is_recurring = (bool) $this->request->post('calendar_is_recurring');
        $reminder->recurring_periodicity = $this->request->post('calendar_recurring_periodicity');
        $reminder->colour = $this->request->post('calendar_colour', '#cccccc');
        $reminder->type_id = EntityEventType::CALENDAR_DATE;
        try {
            $reminder->save();
        } catch (Exception $e) {
            // Something went wrong, silence the issue
            throw $e;
        }
    }
}
