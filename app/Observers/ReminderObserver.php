<?php

namespace App\Observers;

use App\Models\Reminder;

class ReminderObserver
{
    public function saving(Reminder $reminder)
    {
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
