<?php

namespace App\Renderers;

use App\Models\Calendar;
use App\Models\CalendarEvent;
use App\Models\Event;
use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Initializer
     * @param Calendar $calendar
     */
    public function setCalendar(Calendar $calendar)
    {
        $this->calendar = $calendar;
        $this->buildCurrentSegments();
    }

    /**
     * Get previous month link
     * @return string
     */
    public function previous()
    {
        $month = $this->segments[1]-1;
        $year = $this->segments[0]+0;
        $months = $this->calendar->months();

        if ($month <= 0) {
            $year--;
            $month = count($months);
        }

        return HtmlFacade::linkRoute('calendars.show', $months[$month-1]['name'] . " $year", ['calendar' => $this->calendar, 'month' => $month, 'year' => $year]);
    }

    /**
     * Get current year-month
     * @return string
     */
    public function current()
    {
        $month = $this->segments[1];
        $year = $this->segments[0]+0;
        $months = $this->calendar->months();
        $options = '';
        // Year name?
        $names = $this->calendar->years();

        for ($y = $year - 5; $y <= $year + 5; $y++) {
            $yearName = '';
            if (!empty($names[$y])) {
                $yearName = ' "' . $names[$y] . '"';
            }
            $route = route('calendars.show', ['calendar' => $this->calendar, 'year' => $y, 'month' => $month]);
            $options .= "<option value=\"$route\"" . ($y == $year ? ' selected="selected"' : null) . ">" . $months[$month-1]['name'] . " $y$yearName</option>";
        }

        return $options;
    }

    /**
     * Get next month link
     * @return string
     */
    public function next()
    {
        $month = $this->segments[1]+1;
        $year = $this->segments[0]+0;
        $months = $this->calendar->months();

        if ($month > count($months)) {
            $year++;
            $month = 1;
        }

        return HtmlFacade::linkRoute('calendars.show', $months[$month-1]['name'] . " $year", ['calendar' => $this->calendar, 'month' => $month, 'year' => $year]);
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
        $data = [];

        $offset = $this->weekStartoffset();
        $events = $this->events();

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
                $exact = $this->segments[0] . '-' . $this->segments[1] . '-' . $day;
                $dayData = [
                    'day' => $day,
                    'events' => [],
                    'date' => $exact
                ];

                if (isset($events[$exact])) {
                    $dayData['events'] = $events[$exact];
                }
                $week[] = $dayData;
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

        return $data;
    }

    /**
     * @return mixed
     */
    public function currentMonthId()
    {
        return $this->segments[1];
    }

    /**
     * @return string
     */
    public function yearSwitcher()
    {
        $currentYear = $this->segments[0];
        $months = $this->calendar->months();
        $html = '';
        for ($year = $currentYear - 3; $year <= $currentYear + 3; $year++) {
            $html .= '<div class="col-md-' . ($year == $currentYear ? '2 text-center' : 1) . '">' .
                ($year < $currentYear ? '<i class="fa fa-angle-double-left"></i> ' : null) .
                HtmlFacade::linkRoute('calendars.show', "$year " . $months[0]['name'], ['calendar' => $this->calendar, 'year' => $year, 'month' => 1]) .
                ($year > $currentYear ? ' <i class="fa fa-angle-double-right"></i>' : null) .
                '</div>';
        }
        return $html;
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

            // If the month is too big? Then use the max
            if ($this->segments[1] > count($this->calendar->months())) {
                $this->segments[1] = count($this->calendar->months()) ;
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

        if ($this->calendar->has_leap_year && $this->segments[0] >= $this->calendar->leap_year_start) {
            // Calc the number of years that were leap years
            $amountOfYears = floor(($this->segments[0] - $this->calendar->leap_year_start) / $this->calendar->leap_year_offset);
            if ($amountOfYears < 0) {
                $amountOfYears = 0;
            }

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

    /**
     * Load events of the year and month
     * @return array
     */
    protected function events()
    {
        $events = [];
        foreach ($this->calendar->calendarEvents()
                     ->has('entity')
                     ->with('entity')
                    ->where(function ($query) {
                        $query
                            ->where('date', 'like', $this->segments[0] . '-' . $this->segments[1] . '%')
                            ->orWhere(function ($sub) {
                                $sub->where('date', 'like', '%-' . $this->segments[1] . '-%')
                                    ->whereYear('date', '<=', $this->segments[0])
                                    ->where('is_recurring', true);
                            });
                    })
                     ->get() as $event) {
            // Calc date
            $date = $event->date;
            if ($event->is_recurring) {
                $blocks = explode('-', $date);
                $date = $this->segments[0] . '-' . $blocks[1] . '-' . $blocks[2];
            }
            if (!isset($events[$date])) {
                $events[$date] = [];
            }

            // Make sure the user can actually see the requested event
            if (Auth::user()->can('view', $event->entity->child)) {
                $events[$date][] = $event;
            }
        }
        return $events;
    }
}
