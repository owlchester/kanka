<?php

namespace App\Renderers;

use App\Models\Calendar;
use Collective\Html\HtmlFacade;

class CalendarRenderer
{
    /**
     * @var Calendar
     */
    protected $calendar;

    /**
     * Segments of the date
     * @var array
     */
    protected $segments = false;

    public function __construct()
    {
        // Get the calendar from the router
        $this->calendar = request()->route('calendar');


        $this->buildCurrentSegments();
    }

    /**
     * Get previous month link
     * @return string
     */
    public function previous()
    {
        $month = $this->segments[1]-1;
        $year = $this->segments[0];
        $months = $this->calendar->months();

        if ($month <= 0) {
            $year--;
            $month = count($months);
        }

        return HtmlFacade::linkRoute('calendars.show', "$year " . $months[$month-1]['name'], ['calendar' => $this->calendar, 'month' => $month, 'year' => $year]);
    }

    /**
     * Get current year-month
     * @return string
     */
    public function current()
    {
        $month = $this->segments[1];
        $year = $this->segments[0];
        $months = $this->calendar->months();

        // Year name?
        $names = $this->calendar->years();
        $yearName = '';
        if (!empty($names[$year])) {
            $yearName = '"' . $names[$year] . '" ';
        }


        return "$year $yearName" . $months[$month-1]['name'];
    }

    /**
     * Get next month link
     * @return string
     */
    public function next()
    {
        $month = $this->segments[1]+1;
        $year = $this->segments[0];
        $months = $this->calendar->months();

        if ($month > count($months)) {
            $year++;
            $month = 1;
        }

        return HtmlFacade::linkRoute('calendars.show', "$year " . $months[$month-1]['name'], ['calendar' => $this->calendar, 'month' => $month, 'year' => $year]);
    }

    /**
     * Build the month with the weeks and days
     * @return array
     */
    public function month()
    {
        // Number of weeks in this month?
        $weekdays = $this->calendar->weekdays();
        $months = $this->calendar->months();
        $month = $months[$this->segments[1]-1];

        // Amount of weeks in this month: number of days in the month / length of a week
        $weekCount = ceil($month['length'] / count($weekdays));

        $data = [];
        $dayNumber = 1;

        $offset = $this->weekStartoffset();

        // Check if this month is a leap month
        if ($this->calendar->has_leap_year) {
            if ($this->calendar->leap_year_month == $this->segments[1]) {
                // Is this the starting year, or an increment of the offset?
                $handle = $this->segments[0] - $this->calendar->leap_year_start;
                if ($handle % $this->calendar->leap_year_offset === 0) {
                    $month['length'] += $this->calendar->leap_year_amount;
                }
            }
        }

        $weekLength = 0;
        $week = [];
        for ($day = 1; $day <= $month['length']; $day++) {
            if ($offset > 0) {
                $week[] = null;
                $offset--;
                $day--;
            } else {
                $week[] = $day;
            }

            $weekLength++;

            if (count($week) >= count($weekdays)) {
                $data[] = $week;
                $week = [];
            }
        }

        // Fill in the last week?
        $lastWeekDiff = count($week) - count($weekdays);
        if ($lastWeekDiff < 0) {
            for ($day = $lastWeekDiff; $day < 0; $day++) {
                $week[] = null;
            }
        }

        $data[] = $week;

//        for ($week = 1; $week <= $weekCount; $week++) {
//            $weekData = [];
//            $weekDay = 0;
//            foreach ($weekdays as $day) {
//                // Offset for first week
//                if ($week == 1 && $offset > 0) {
//                    $offset--;
//                    $weekData[] = null;
//                }
//                // Don't go over the max of the month length
//                elseif ($dayNumber > $month['length']) {
//                    $weekData[] = null;
//                } else {
//                    $weekData[] = $dayNumber;
//                    $dayNumber++;
//                }
//                $weekDay++;
//            }
//
//            $data[] = $weekData;
//        }
        return $data;
    }

    /**
     *
     */
    protected function buildCurrentSegments()
    {
        if ($this->segments === false) {
            $this->segments = explode('-', $this->calendar->date);

            if (request()->has('month')) {
                $this->segments[1] = request()->input('month');
            }
            if (request()->has('year')) {
                $this->segments[0] = request()->input('year');
            }

            if (empty($this->segments[1])) {
                $this->segments[1] = 1;
            }
        }
    }

    /**
     * Calculate the month starting offset
     * @return float
     */
    protected function weekStartOffset()
    {
        // We assume that the 01 01 01 is a monday.
        // We need to know how many days elapsed since that day, to calculate the offset (total days / week length)

        $daysInAYear = $days = $leapDays = 0;
        foreach ($this->calendar->months() as $count => $month) {
            $length = $month['length'];
            $daysInAYear += $length;

            // If the month has already passed, add it to the days for this year
            if ($count < $this->segments[1]-1) {
                $days += $length;
            }
        }

        if ($this->calendar->has_leap_year) {
            // Calc the number of years that were leap years
            $amountOfYears = floor(($this->segments[0] - $this->calendar->leap_year_start) / $this->calendar->leap_year_offset);
            $leapDays = $amountOfYears * $this->calendar->leap_year_amount;

            // But if we are a leap year, we need to do the math
            if ($this->segments[0] % $this->calendar->leap_year_start == 0) {
                if ($this->segments[1] > $this->calendar->leap_year_month) {
                    // We've passed the leap month of the year
                    $leapDays += $this->calendar->leap_year_amount;
                }
            }
        }

        // Amount of days since the beginning of the year
        $totalDays = ($daysInAYear * $this->segments[0]) + $days + $leapDays;
        $weekLength = count($this->calendar->weekdays());
        $offset = floor($totalDays % $weekLength);

        return $offset;
    }
}
