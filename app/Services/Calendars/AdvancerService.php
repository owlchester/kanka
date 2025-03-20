<?php

namespace App\Services\Calendars;

use App\Jobs\CalendarsClearElapsed;
use App\Models\Calendar;

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
        [$year, $month, $day] = $this->calendar->dateArray();

        // Day is longer than month max length?
        $months = $this->calendar->months();
        if (! empty($day)) {
            $day = ((int) $day) + 1;
            if ($day > $months[$month - 1]['length']) {
                $day = 1;
                $month++;
            }
        } else {
            $month++;
        }

        // Reset month and increment year
        if ($month > count($months)) {
            $month = 1;
            $year++;
        }

        if (! $this->calendar->hasYearZero() && $year == 0) {
            $year++;
        }
        $this->calendar->date = $year . '-' . $month . ($day !== false ? '-' . $day : null);
        $this->calendar->save();

        return $this;
    }

    /**
     * Retreat a calendar's date by one day
     */
    public function retreat(): self
    {
        [$year, $month, $day] = $this->calendar->dateArray();

        $day--;
        $months = $this->calendar->months();
        if ($day < 1) {
            $month--;
            if ($month < 1) {
                $month = count($months);
                $year--;
            }
            $day = $months[$month - 1]['length'];
        }

        if (! $this->calendar->hasYearZero() && $year == 0) {
            $year--;
        }
        $this->calendar->date = $year . '-' . $month . '-' . $day;
        $this->calendar->save();
        CalendarsClearElapsed::dispatch($this->calendar);

        return $this;
    }
}
