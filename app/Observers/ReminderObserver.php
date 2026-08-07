<?php

namespace App\Observers;

use App\Enums\EntityEventTypes;
use App\Models\Entity;
use App\Models\Reminder;
use Stevebauman\Purify\Facades\Purify;

class ReminderObserver
{
    public function saving(Reminder $reminder)
    {
        if ($reminder->comment !== null) {
            $reminder->comment = Purify::clean($reminder->comment);
        }

        if (! $reminder->exists && $reminder->type_id === null && $reminder->remindable instanceof Entity) {
            $entity = $reminder->remindable;
            $eligibleTypes = [
                config('entities.ids.journal'),
                config('entities.ids.quest'),
                config('entities.ids.event'),
            ];

            if (in_array($entity->type_id, $eligibleTypes) && $entity->calendarDate === null) {
                $reminder->type_id = EntityEventTypes::calendarDate;
            }
        }

        $reminder->is_recurring = ! empty($reminder->recurring_periodicity);
        if (! $reminder->is_recurring) {
            $reminder->recurring_until = null;
        }
    }

    public function updating(Reminder $reminder)
    {
        // When updating and elapsed isn't dirty (calculated on the overview), reset it
        if ($reminder->isDirty(['year', 'month', 'day', 'calendar_id'])) {
            $reminder->elapsed = null;
        }
    }

    public function updated(Reminder $reminder)
    {
        // Go touch linked entity and its child
        $reminder->remindable->touchSilently();
    }

    public function deleted(Reminder $reminder)
    {
        // Go touch linked entity and its child
        $reminder->remindable->touchSilently();
    }
}
