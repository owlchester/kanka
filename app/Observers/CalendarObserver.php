<?php

namespace App\Observers;

use App\Jobs\CalendarsClearElapsed;
use App\Models\Calendar;

class CalendarObserver extends MiscObserver
{
    public function saved(Calendar $calendar)
    {
        if ($calendar->isDirty(['date'])) {
            CalendarsClearElapsed::dispatch($calendar);
        }
    }
}
