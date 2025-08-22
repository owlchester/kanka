<?php

namespace App\Services\Calendars;

use App\Traits\CalendarAware;
use Illuminate\Support\Arr;

class DaysService
{
    use CalendarAware;

    protected bool $intercalary = true;
    protected int $mont;
    protected int $year;
    protected int $day;

    public function intercalary(bool $intercalary): self
    {
        $this->intercalary = $intercalary;

        return $this;
    }

    public function month(int $month): self
    {
        $this->month = $month;
        return $this;
    }
    public function day(int $day): self
    {
        $this->day = $day;
        return $this;
    }
    public function year(int $year): self
    {
        $this->year = $year;
        return $this;
    }

    public function daysToDate(): int
    {
        // We assume that the 01 01 00 is a monday.
        // We need to know how many days elapsed since that day, to calculate the offset (total days / week length)

        $daysInAYear = $days = $leapDays = 0;
        foreach ($this->calendar->months() as $count => $month) {
            if (! $this->intercalary && Arr::get($month, 'type') == 'intercalary') {
                continue;
            }
            $length = $month['length'];
            $daysInAYear += $length;

            // If the month has already passed, add it to the days for this year
            if ($count < $this->month - 1) {
                $days += $length;
            }
        }

        if ($this->calendar->has_leap_year && $this->year >= $this->calendar->leap_year_start) {
            // If the leap month is intercalary, we don't need to offset anything.
            $months = $this->calendar->months();
            $leapMonth = Arr::get($months, $this->calendar->leap_year_month - 1, false);
            if ($leapMonth && Arr::get($leapMonth, 'type') == 'intercalary') {
                // Nothing
            } else {
                // Calc the number of years that were leap years
                //            dump("the current year (" . $this->getYear() . ") is >= to when the calendar leap year starts
                //               (" . $this->calendar->leap_year_start . ")");
                $yearDiffWithLeapStart = $this->year - $this->calendar->leap_year_start;
                $amountOfYears = ceil($yearDiffWithLeapStart / max(1, $this->calendar->leap_year_offset));
                //            dump ("the amount of leap years that has elapsed since the beginning is the following: $amountOfYears");
                //            dump ("the value is ceil((" . $this->getYear() . "-" . $this->calendar->leap_year_start . ")
                //               / " . $this->calendar->leap_year_offset . ")");
                if ($amountOfYears < 0) {
                    $amountOfYears = 0;
                }

                $leapDays = $amountOfYears * $this->calendar->leap_year_amount;

                //            dump ("total leap days elapsed: $leapDays");

                // But if we are a leap year, we need to do the math
                if (($this->year - $this->calendar->leap_year_start) % max($this->calendar->leap_year_offset, 1) == 0) {
                    if ($this->month > $this->calendar->leap_year_month) {
                        // We've passed the leap month of the year
                        $leapDays += $this->calendar->leap_year_amount;
                    }
                }
            }
        }

        // Number of days since the beginning of the year
        if (! $this->calendar->hasYearZero() && $this->year > 0) {
            return ($daysInAYear * ($this->year - 1)) + $days + $leapDays;
        }

        return ($daysInAYear * $this->year) + $days + $leapDays;
    }
}
