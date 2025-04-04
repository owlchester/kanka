<?php

namespace App\Observers;

use App\Models\Calendar;
use App\Models\Entity;
use App\Models\EntityEventType;
use App\Models\Quest;
use App\Models\Reminder;
use Exception;
use Illuminate\Database\Eloquent\Model;

class Remindable
{
    public function saved(Model $model)
    {
        // If we don't have an entity, not exactly sure what's going on. Skip the entity event
        // observer and let the user report it instead of throwing an ugly error at them.
        if (empty($model->entity)) {
            return;
        }

        // The user is editing an entity with a calendar, but doesn't have the permission to see
        // the calendar? We skip any work.
        if (request()->has('calendar_skip')) {
            return;
        }

        $entity = $model->entity;

        // Previously, this lookup was only triggered when the calendar_id or date was dirty. However, this excludes just
        // changing the colour or periodicity. To support the API not overriding the values, we still check to make
        // sure that the calendar_id property is set.
        if (! request()->has('calendar_id')) {
            return;
        }
        $calendarID = request()->post('calendar_id');

        // We already had this event linked
        /** @var Quest $model */
        $reminder = $model->calendarReminder();
        if ($reminder !== null) {
            // We no longer have a calendar attached to this model
            if ($calendarID === null) {
                $reminder->delete();

                return;
            }
        } else {
            $reminder = new Reminder;
            $reminder->remindable_type = Entity::class;
            $reminder->remindable_id = $entity->id;
        }

        // Validate the calendar
        /** @var ?Calendar $calendar */
        $calendar = Calendar::find($calendarID);
        if ($calendar === null || $calendar->missingDetails()) {
            return;
        }

        $length = request()->post('calendar_length', '1');
        $length = max(1, $length);
        $reminder->calendar_id = request()->get('calendar_id');
        $reminder->year = (int) request()->post('calendar_year', '1');
        $reminder->month = (int) request()->post('calendar_month', '1');
        $reminder->day = (int) request()->post('calendar_day', '1');
        $reminder->length = $length;
        $reminder->is_recurring = (bool) request()->post('calendar_is_recurring');
        $reminder->recurring_periodicity = request()->post('calendar_recurring_periodicity');
        $reminder->colour = request()->post('calendar_colour', '#cccccc');
        $reminder->type_id = EntityEventType::CALENDAR_DATE;
        try {
            $reminder->save();
        } catch (Exception $e) {
            // Something went wrong, silence the issue
            throw $e;
        }
    }
}
