<?php

namespace App\Traits;

use App\Models\Calendar;

trait CalendarAware
{
    public Calendar $calendar;

    public function calendar(Calendar $calendar): self
    {
        $this->calendar = $calendar;

        return $this;
    }
}
