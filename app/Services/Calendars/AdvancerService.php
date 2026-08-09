<?php

namespace App\Services\Calendars;

use App\Jobs\CalendarsClearElapsed;
use App\Models\Calendar;
use App\ValueObjects\Calendars\CalendarDate;

class AdvancerService
{
    protected Calendar $calendar;

    public function calendar(Calendar $calendar): self
    {
        $this->calendar = $calendar;

        return $this;
    }

    /**
     * Advance a calendar's date by one day
     */
    public function advance(): self
    {
        $date = $this->currentDate();
        $this->calendar->date = (string) $this->calendar->chronology()->addDays($date, 1);
        $this->calendar->saveQuietly();

        return $this;
    }

    /**
     * Retreat a calendar's date by one day
     */
    public function retreat(): self
    {
        $date = $this->currentDate();
        $this->calendar->date = (string) $this->calendar->chronology()->addDays($date, -1);
        $this->calendar->save();
        CalendarsClearElapsed::dispatch($this->calendar);

        return $this;
    }

    private function currentDate(): CalendarDate
    {
        return new CalendarDate(...array_map('intval', $this->calendar->dateArray()));
    }
}
