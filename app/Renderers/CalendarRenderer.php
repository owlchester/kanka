<?php

namespace App\Renderers;

use App\Models\Calendar;
use App\Models\CalendarWeather;
use App\Models\EntityEvent;
use App\Models\EntityEventType;
use App\Traits\CampaignAware;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class CalendarRenderer
{
    use CampaignAware;

    /**
     */
    protected Calendar $calendar;

    /**
     * Segments of the date
     */
    protected bool $segments = false;

    /**
     * Current month
     * @var integer
     */
    protected int $month;

    /**
     * Current Year
     */
    protected int $year;

    /**
     * Full moons
     */
    protected array $moons = [];

    /**
     * Weather
     */
    protected array $weather = [];

    /**
     * Season Changes
     */
    protected array $seasons = [];

    /**
     * Named Weeks
     */
    protected array $weeks = [];

    /**
     * Death events
     */
    protected array $deaths = [];

    /**
     * Birthday events
     */
    protected array $births = [];

    /**
     * Array of weirdly recurring events
     */
    protected array $recurring = [];

    /**
     * Layout option
     */
    protected string $layout = 'year';

    /**
     * Events displayed on the calendar view
     */
    protected array $events = [];

    /**
     * Start date of events displayed on the calendar view
     */
    protected array $eventStart = [];

    /**
     * End date of events displayed on the calendar view
     */
    protected array $eventEnd = [];

    /**
     * Initializer
     */
    public function setCalendar(Calendar $calendar)
    {
        $this->calendar = $calendar;
        $this->buildCurrentSegments();
    }

    /**
     * Get previous month link
     */
    public function previous(bool $title = false): string
    {
        $month = $this->getMonth(-1);
        $year = $this->getYear();
        $months = $this->calendar->months();

        // Yearly navigation
        if ($this->isYearlyLayout()) {
            $year--;
            if (!$this->calendar->hasYearZero() && $year == 0) {
                $year--;
            }
            if ($title) {
                return (string) $year;
            } else {
                return route(
                    'entities.show',
                    [$this->campaign, 'entity' => $this->calendar->entity, 'layout' => 'year', 'year' => $year]
                );
            }
        }

        if ($month <= 0) {
            $year--;
            if (!$this->calendar->hasYearZero() && $year == 0) {
                $year--;
            }
            $month = count($months);
        }

        if ($title) {
            return $months[$month - 1]['name'] . " {$year}";
        }

        $routeOptions = [$this->campaign, 'entity' => $this->calendar->entity, 'month' => $month, 'year' => $year];
        if ($this->calendar->defaultLayout() === 'year') {
            // @phpstan-ignore-next-line
            $routeOptions['layout'] = $this->isYearlyLayout() ? 'year' : 'month';
        }
        return route(
            'entities.show',
            $routeOptions
        );
    }

    /**
     * Build a link to a year
     */
    public function linkToYear(bool $next = true): string
    {
        $month = $this->getMonth();
        $year = $this->getYear($next ? 1 : -1);
        if (!$this->calendar->hasYearZero() && $year == 0) {
            if ($next) {
                $year++;
            } else {
                $year--;
            }
        }

        $options = [
            'campaign' => $this->campaign,
            'entity' => $this->calendar->entity,
            'month' => $month,
            'year' => $year,
        ];
        if ($this->isYearlyLayout()) {
            if (!$this->calendar->yearlyLayout()) {
                $options['layout'] = 'year';
            }
            unset($options['month']);
        } elseif ($this->calendar->yearlyLayout()) {
            $options['layout'] = 'month';
        }

        return route(
            'entities.show',
            $options
        );
    }

    /**
     * Get the title to a year
     */
    public function titleToYear(bool $next = true): string
    {
        $month = $this->getMonth();
        $year = $this->getYear($next ? 1 : -1);
        if (!$this->calendar->hasYearZero() && $year == 0) {
            if ($next) {
                $year++;
            } else {
                $year--;
            }
        }

        if ($this->isYearlyLayout()) {
            return (string) $year;
        }

        $months = $this->calendar->months();
        return $months[$month - 1]['name'] . " {$year}";
    }

    /**
     * Get current year-month
     */
    public function currentMonthName(): string
    {
        $months = $this->calendar->months();
        $month = $months[$this->getMonth(-1)];
        $monthName = e(Arr::get($month, 'name', ''));
        $monthName = '' . $monthName . '';

        return ($this->isYearlyLayout() ? '' : $monthName);
    }

    public function currentYearName(): string
    {
        // Year name
        $year = $this->getYear();
        $names = $this->calendar->years();
        $yearText = $year;
        if (isset($names[$year])) {
            $safeName = e($names[$year]);
            $yearText = "<span title=\"{$year}\">{$safeName}</span>";
        }
        return $yearText;
    }

    /**
     */
    public function monthAlias(): string
    {
        $months = $this->calendar->months();
        $month = $months[$this->getMonth(-1)];
        $alias = Arr::get($month, 'alias', '');

        if (empty($alias)) {
            return '';
        }

        // Month alias is already escaped on saving so let's skip it here
        return $alias;
    }

    /**
     * Get next month link
     */
    public function next($title = false): string
    {
        $month = $this->getMonth(1);
        $year = $this->getYear();
        $months = $this->calendar->months();

        // Yearly navigation
        if ($this->isYearlyLayout()) {
            $year++;
            if (!$this->calendar->hasYearZero() && $year == 0) {
                $year++;
            }
            if ($title) {
                return (string) $year;
            } else {
                return route(
                    'entities.show',
                    [$this->campaign, 'entity' => $this->calendar->entity, 'layout' => 'year', 'year' => $year]
                );
            }
        }

        if ($month > count($months)) {
            $year++;
            if (!$this->calendar->hasYearZero() && $year == 0) {
                $year++;
            }
            $month = 1;
        }

        if ($title) {
            return $months[$month - 1]['name'] . " {$year}";
        }

        $routeOptions = [$this->campaign, 'entity' => $this->calendar->entity, 'month' => $month, 'year' => $year];
        if ($this->calendar->yearlyLayout()) {
            // @phpstan-ignore-next-line
            $routeOptions['layout'] = $this->isYearlyLayout() ? 'year' : 'month';
        }
        return route(
            'entities.show',
            $routeOptions
        );
    }

    /**
     * Build the calendar events for a month view
     * @return array
     */
    public function buildForMonth()
    {
        // Number of weeks in this month?
        $weekdays = $this->calendar->weekdays();
        $months = $this->calendar->months();
        $month = $months[$this->getMonth() - 1];
        $data = [];

        // If weeks reset on the first day of the week, skip the offset
        $offset = 0;
        if (empty($this->calendar->reset) || ($this->calendar->reset === 'year' && $this->getMonth() != 1)) {
            $offset = $this->weekStartoffset();

            if ($this->calendar->start_offset > 0) {
                $offset += $this->calendar->start_offset;
            } elseif ($this->calendar->start_offset < 0) {
                $offset += count($weekdays) + $this->calendar->start_offset;
            }
        }
        $events = $this->events();

        if (Arr::get($month, 'type') == 'intercalary') {
            $offset = 0;
        }

        // Check if this month is a leap month
        if ($this->calendar->has_leap_year) {
            if ($this->calendar->leap_year_month == $this->getMonth()) {
                // Is this the starting year, or an increment of the offset?
                $handle = $this->getYear() - $this->calendar->leap_year_start;
                if ($handle % $this->calendar->leap_year_offset === 0) {
                    $month['length'] += $this->calendar->leap_year_amount;
                }
            }
        }

        // If the offset is higher than a week, let's scale it down a week to avoid an empty week row
        if ($offset >= count($weekdays)) {
            $offset -= count($weekdays);
        }

        // Define the week number from the start of the year
        $weekNumber = $this->startingWeekNumber();
        //dump("starting week number: " . $weekNumber);

        $monthLength = $month['length'];
        $weekLength = 0;
        $week = [];
        $remainingRecurring = [];

        // Calc julian based on previous months
        $julian = 1;
        for ($passedMonth = 1; $passedMonth < $this->getMonth(); $passedMonth++) {
            $passedMonthData = $months[$passedMonth - 1];
            $julian += $passedMonthData['length'];
        }

        for ($day = 1; $day <= $monthLength; $day++) {
            if ($offset > 0) {
                $week[] = null;
                $offset--;
                $day--;
            } else {
                $exact = $this->getYear() . '-' . $this->getMonth() . '-' . $day;
                $dayData = [
                    'day' => $day,
                    'year' => $this->getYear(),
                    'month' => $this->getMonth(),
                    'events' => [],
                    'date' => $exact,
                    'isToday' => false,
                    'julian' => $julian
                ];

                if (isset($events[$exact])) {
                    $dayData['events'] = $events[$exact];
                }

                if ($exact == $this->calendar->date) {
                    $dayData['isToday'] = true;
                }

                if (isset($this->moons[$day])) {
                    $dayData['moons'] = $this->moons[$day];
                }

                if (isset($this->weather[$exact])) {
                    $dayData['weather'] = $this->weather[$exact];
                }

                $monthday = $this->getMonth() . '-' . $day;
                if (isset($this->seasons[$monthday])) {
                    $dayData['season'] = $this->seasons[$monthday];
                }

                // Add recurring events that span multiple days from the previous call
                $newRemaining = [];
                foreach ($remainingRecurring as $recurring) {
                    if ($recurring['remaining'] == 1) {
                        $this->eventEnd[$recurring['event']->id][] = $dayData['date'];
                    }
                    $dayData['events'][] = $recurring['event'];
                    if ($recurring['remaining'] > 1) {
                        $newRemaining[] = ['remaining' => $recurring['remaining'] - 1, 'event' => $recurring['event']];
                    }
                }
                $remainingRecurring = $newRemaining;

                // Add recurring events if the moon stuff fits
                if (!empty($dayData['moons'])) {
                    foreach ($dayData['moons'] as $moon) {
                        $key = $moon['id'] . '_' . $moon['type'][0];
                        if (!isset($this->recurring[$key])) {
                            continue;
                        }
                        /** @var EntityEvent $event */
                        //dump'found events for ' . $key);
                        foreach ($this->recurring[$key] as $event) {
                            if (!$event->isPastDate($this->getYear(), $this->getMonth(), $day)) {
                                //dd("$event->year $event->month $event->day is past {$this->getYear()} {$this->getMonth()} $day");
                                continue;
                            }
                            $dayData['events'][] = $event;

                            if ($event->length > 1) {
                                $this->eventStart[$event->id][] = $dayData['date'];
                                $remainingRecurring[] = ['remaining' => $event->length - 1, 'event' => $event];
                            }
                        }
                    }
                }
                $week[] = $dayData;
                $julian++;
            }

            $weekLength++;

            if (count($week) >= count($weekdays)) {
                $data[$weekNumber] = $week;
                $week = [];
                $weekNumber++;
            }
        }

        // Fill in the last week?
        $lastWeekDiff = count($week) - count($weekdays);
        if ($lastWeekDiff < 0) {
            if (abs($lastWeekDiff) >= count($weekdays)) {
                $lastWeekDiff += count($weekdays);
            }
            for ($day = $lastWeekDiff; $day < 0; $day++) {
                $week[] = null;
            }
        }


        $data[$weekNumber] = $week;

        return $data;
    }

    /**
     * Build the calendar for the yearly view
     */
    public function buildForYear(): array
    {
        // Number of weeks in this month?
        $weekdays = $this->calendar->weekdays();
        $months = $this->calendar->months();
        $julian = 1;
        $data = [];

        $events = $this->events();

        $offset = 0;
        if (empty($this->calendar->reset) || ($this->calendar->reset === 'year' && $this->getMonth() != 1)) {
            $offset = $this->weekStartoffset();

            if ($this->calendar->start_offset > 0) {
                $offset += $this->calendar->start_offset;
            } elseif ($this->calendar->start_offset < 0) {
                $offset += count($weekdays) + $this->calendar->start_offset;
            }
        }

        // Add empty days for the beginning of the year
        for ($i = $offset; $i > 0; $i--) {
            $data[] = null;
        }

        $weekLength = count($weekdays);
        $monthNumber = 1;
        $weekNumber = $offset > 0 && empty($this->calendar->reset) ? 2 : 1;
        //dump('Starting week number: ' . $weekNumber);
        $totalDay = 1;
        $weekday = 1;
        foreach ($months as $month) {
            //dump('Month: ' . $month['name']);
            //if ($weekNumber)
            $month = $months[$monthNumber - 1];
            $this->month = $monthNumber;

            // Check if this month is a leap month
            if ($this->calendar->has_leap_year) {
                if ($this->calendar->leap_year_month == $monthNumber) {
                    // Is this the starting year, or an increment of the offset?
                    $handle = $this->getYear() - $this->calendar->leap_year_start;
                    if ($handle % $this->calendar->leap_year_offset === 0) {
                        $month['length'] += $this->calendar->leap_year_amount;

                        // If it also happens to add days on an intercalary day, we need to influence the number of days
                        // added at the end of the month.
                    }
                }
            }

            $monthLength = $month['length'];
            $week = [];
            $currentPosition = 0;

            // If the month is intercalary, we need to offset to the "beginning" of the week
            if (Arr::get($month, 'type') == 'intercalary') {
                $totalDays = count($data);
                $emptyDaysToFill = $weekLength - ($totalDays % $weekLength);
                $currentPosition = $weekLength - $emptyDaysToFill; // On which week day we currently are

                // Don't fill a whole empty week
                if ($emptyDaysToFill == $weekLength) {
                    $emptyDaysToFill = 0;
                }

                for ($d = 0; $d < $emptyDaysToFill; $d++) {
                    $data[] = [];
                }
            }

            // Add each day of the month to the day thing
            $remainingRecurring = [];
            $endedWeek = false;
            for ($day = 1; $day <= $monthLength; $day++) {
                $endedWeek = false;
                $exact = $this->getYear() . '-' . $monthNumber . '-' . $day;
                //if ($weekNumber < 13) dump('new day ' . $weekday . ', ' . $totalDay . ', ' . $exact);
                $dayData = [
                    'day' => $day,
                    'events' => [],
                    'date' => $exact,
                    'year' => $this->getYear(),
                    'julian' => $julian,
                    'isToday' => false,
                    'month' => $month['name'],
                    'week' => Arr::get($month, 'type') == 'intercalary' ? null : $weekNumber
                ];

                if (isset($events[$exact])) {
                    $dayData['events'] = $events[$exact];
                }

                if ($exact == $this->calendar->date) {
                    $dayData['isToday'] = true;
                }

                if (isset($this->moons[$totalDay])) {
                    $dayData['moons'] = $this->moons[$totalDay];
                }
                if (isset($this->weather[$exact])) {
                    $dayData['weather'] = $this->weather[$exact];
                }

                // Add recurring events that span multiple days from the previous call
                $newRemaining = [];
                foreach ($remainingRecurring as $recurring) {
                    if ($recurring['remaining'] == 1) {
                        $this->eventEnd[$recurring['event']->id][] = $dayData['date'];
                    }
                    $dayData['events'][] = $recurring['event'];
                    if ($recurring['remaining'] > 1) {
                        $newRemaining[] = ['remaining' => $recurring['remaining'] - 1, 'event' => $recurring['event']];
                    }
                }
                $remainingRecurring = $newRemaining;

                // Add recurring events if the moon stuff fits
                if (!empty($dayData['moons'])) {
                    foreach ($dayData['moons'] as $moon) {
                        $key = $moon['id'] . '_' . $moon['type'][0];
                        if (!isset($this->recurring[$key])) {
                            continue;
                        }
                        /** @var EntityEvent $event */
                        //dump('found events for ' . $key);
                        foreach ($this->recurring[$key] as $event) {
                            if (!$event->isPastDate($this->getYear(), $this->getMonth(), $day)) {
                                continue;
                            }
                            $dayData['events'][] = $event;

                            if ($event->length > 1) {
                                $this->eventStart[$event->id][] = $dayData['date'];
                                $remainingRecurring[] = ['remaining' => $event->length - 1, 'event' => $event];
                            }
                        }
                    }
                }

                $monthday = $monthNumber . '-' . $day;
                if (isset($this->seasons[$monthday])) {
                    $dayData['season'] = $this->seasons[$monthday];
                }
                $data[] = $dayData;

                $totalDay++;

                // If we're hitting the end of the week, go down
                if ($weekday % $weekLength == 0 && Arr::get($month, 'type') != 'intercalary') {
                    //if ($weekNumber < 13) dump('end of the week: week ' . $weekNumber . ' is over, going to ' . ($weekNumber+1));
                    $weekNumber++;
                    $endedWeek = true;
                    $weekday = 1;
                } else {
                    $weekday++;
                }

                // Increase the julian date by one
                $julian++;
            }

            //if ($weekNumber < 13) dump('finished the month. Did we end the week on the last day? ' . ($endedWeek ? 'yes' : 'no'));


            // If the month is intercalary, we need to fill out the rest of the "week" until where it starts again
            // Or iff we have resets on the end of the month, we need to fill in some empty days
            if (Arr::get($month, 'type') == 'intercalary' || $this->calendar->reset === 'month') {
                //if ($weekNumber < 13) dump('there is a reset going on here');
                $totalDays = count($data);
                $emptyDaysToFill = $weekLength - ($totalDays % $weekLength);

                // Don't fill a whole empty week
                if ($emptyDaysToFill == $weekLength) {
                    $emptyDaysToFill = 0;
                }

                for ($d = 0; $d < $emptyDaysToFill; $d++) {
                    $data[] = [];
                }

                // Fill out the next month beginning if needed
                // Only add at the beginning if we don't reset on first day of the week
                if (!$this->calendar->reset == 'month') {
                    for ($d = 0; $d < $currentPosition; $d++) {
                        $data[] = [];
                    }
                } elseif (!$endedWeek) {
                    // Only increase the week number if the reset didn't happen on the last day of the previous month,
                    // otherwise we are skipping a week number.
                    //if ($weekNumber < 13) dump('reset: week ' . $weekNumber . ' is over, going to ' . ($weekNumber+1));
                    $weekNumber++;
                    $weekday = 1;
                }
            }

            $monthNumber++;
        }

        return $data;
    }

    /**
     */
    public function currentMonthId()
    {
        return $this->getMonth();
    }

    /**
     * Determine if the "today" button is disabled.
     */
    public function todayButtonIsDisabled(): bool
    {
        $calendarYear = $this->calendar->currentDate('year');
        $calendarMonth = $this->calendar->currentDate('month');

        return (bool) ($this->year == $calendarYear && $this->month == $calendarMonth)


        ;
    }

    /**
     * @return bool
     */
    public function isIntercalaryMonth()
    {
        $month = $this->currentMonthId() - 1;
        foreach ($this->calendar->months() as $k => $m) {
            if ($k == $month && Arr::get($m, 'type') == 'intercalary') {
                return true;
            }
        }

        return false;
    }

    /**
     * Build the current month and year segments
     */
    protected function buildCurrentSegments(): void
    {
        if ($this->segments === true) {
            return;
        }
        $this->segments = true;

        $segments = $this->splitDate($this->calendar->date);
        $this->setMonth($segments[1])
            ->setYear($segments[0]);

        if (request()->filled('month')) {
            $this->setMonth((int) request()->input('month'));
        }
        if (request()->filled('year')) {
            $this->setYear((int) request()->input('year'));
        }

        if (empty($this->getMonth())) {
            $this->setMonth(1);
        }

        // If the month is too big? Then use the max
        if ($this->getMonth() > count($this->calendar->months())) {
            $this->setMonth(count($this->calendar->months()));
        }

        // Yearly layout does things a bit differently, reset month to first
        $this->layout = request()->get('layout', $this->calendar->defaultLayout());
        if ($this->isYearlyLayout()) {
            $this->setMonth(1);
        }

        $this->buildFullmoons();
        $this->buildSeasons();
        $this->buildWeeks();
        $this->buildWeather();
    }

    /**
     * Calculate the month starting offset
     */
    protected function weekStartOffset(): int
    {
        $totalDays = $this->daysToDate(false);
        $negativeYear = $totalDays < 0;
        $weekLength = count($this->calendar->weekdays());
        if ($weekLength == 0) {
            $weekLength = 1;
        }

        // If the calendar resets on the first day of the year, we can switch this around
        if ($this->calendar->reset == 'year') {
            $totalDays = $this->daysToDateForYear();
        }

        $totalDays = $negativeYear ? abs($totalDays) : $totalDays;
        $offset = (int) floor($totalDays % $weekLength);

        // If we are in a negative year, we need to reduce the offset from the week length, as we want the last
        // month before the calendar really "starts" to end on the last day of the week.
        return $negativeYear && $this->calendar->reset != 'year' ? $weekLength - $offset : $offset;
    }

    /**
     * Load events of the year and month
     */
    protected function events(): array
    {
        $this->events = [];
        $reminders = $this->getReminders($this->calendar);
        $this->parseReminders($reminders);

        if ($this->calendar->calendar) {
            $reminders = $this->getReminders($this->calendar->calendar);
            $this->parseReminders($reminders);
        }
        //dd($this->events);
        return $this->events;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getReminders(Calendar $calendar)
    {
        return $calendar->calendarEvents()
            ->has('entity')
            ->with(['entity', 'entity.tags', 'entity.image', 'death'])
            ->where(function ($query) {
                $query
                    // Where it's the current year , or current year and current month
                    ->where(function ($sub) {
                        $sub->where('year', $this->getYear());

                        if (!$this->isYearlyLayout()) {
                            $sub->where('month', $this->getMonth());
                        }
                    })
                    // Or where the event is recurring, or recurring on this month
                    ->orWhere(function ($sub) {
                        if ($this->isYearlyLayout()) {
                            $sub->where('is_recurring', true);
                        } else {
                            $sub->where('month', $this->getMonth())
                                ->where('is_recurring', true);
                        }
                    })
                    ->orWhere(function ($sub) {
                        if ($this->calendar->show_birthdays) {
                            $sub->where('year', '<=', $this->getYear())
                                ->whereIn('type_id', [EntityEventType::BIRTH, EntityEventType::DEATH]);
                            if (!$this->isYearlyLayout()) {
                                $sub->where('month', $this->getMonth());
                            }
                        }
                    })
                    // Events from previous year or month that spill over
                    ->orWhere(function ($sub) {
                        $previousYear = $this->getYear(-1);
                        if (!$this->calendar->hasYearZero() && $previousYear == 0) {
                            $previousYear--;
                        }
                        $sub->whereIn('year', [$previousYear, $this->getYear()])
                            ->where('length', '>', 1);
                    })
                    // Events from previous month that spill over
//                    ->orWhere(function ($sub) {
//                        list($year, $month) = $this->subMonth($this->getYear(), $this->getMonth());
//                        $sub->where('year', $year)
//                            ->where('month', $month)
//                            ->where('length', '>', 1);
//                    })

                    // Monthly recurring events
                    ->orWhere(function ($sub) {
                        $sub->where('is_recurring', true);
                    });
            })
            ->get();
    }

    /**
     */
    protected function parseReminders(Collection $reminders): void
    {
        $totalMonths = count($this->calendar->months());
        if (!$this->isYearlyLayout()) {
            $totalMonths = $this->getMonth();
        }
        /** @var EntityEvent $event */
        foreach ($reminders as $event) {
            if ($event->isBirth() && $event->death && $event->death->isPastDate($this->getYear(), $event->month, $event->day)) {
                continue;
            }
            $date = $event->year . '-' . $event->month . '-' . $event->day;

            // If the event is recurring, get the year to make sure it should start showing. This was previously
            // done in the query, but it didn't work on all systems.
            if ($event->is_recurring || $event->isBirth()) {
                if ($event->year > $this->getYear()) {
                    continue;
                }
                // Over max reoccurring year?
                if (!empty($event->recurring_until) && $event->recurring_until < $this->getYear()) {
                    continue;
                }
                $date = $this->getYear() . '-' . $event->month . '-' . $event->day;
            }

            if (!isset($this->events[$date])) {
                $this->events[$date] = [];
            }

            // Make sure the user can actually see the requested event
            if (empty($event->entity) || empty($event->entity->child)) {
                continue;
            }
            // If the event reoccurs each month, let's add it everywhere
            if ($event->recurringMonthly()) {
                $startingMonth = $event->year == $this->getYear() ? $event->month : 1;
                for ($month = $startingMonth; $month <= $totalMonths; $month++) {
                    $recurringDate = $this->getYear() . '-' . $month . '-' . $event->day;
                    $this->events[$recurringDate][] = $event;
                    $this->addMultidayEvent($event, $recurringDate);
                }
            } elseif ($event->is_recurring && $event->recurring_periodicity !== 'year') {
                // If we haven't passed the max date for this event, show it in the recurring blocks
                if (empty($event->recurring_until) || $this->getYear() < $event->recurring_until) {
                    $this->recurring[$event->recurring_periodicity][] = $event;
                }
            } else {
                // Only add it once
                $this->events[$date][] = $event;
                $this->addMultidayEvent($event, $date);
            }
        }

        foreach ($this->births as $key => $birth) {
            if (!isset($this->deaths[$key]) || ($this->deaths[$key]->month > $birth->month || ($this->deaths[$key]->month == $birth->month && $this->deaths[$key]->day > $birth->day))) {
                $date = $this->getYear() . '-' . $birth->month . '-' . $birth->day;
                $this->events[$date][] = $birth;
            }
        }
        //should end the first day of the month
    }

    /**
     * For multi-day event, add it to each day the event lasts
     */
    protected function addMultidayEvent(EntityEvent $reminder, string $date)
    {
        // Does the day go over a few days?
        if ($reminder->length == 1) {
            return;
        }
        // Flag this reminder's start date to show (start) in the UI
        $this->eventStart[$reminder->id][] = $date;

        // For each length of the reminder, add it to the UI
        $extraDate = $date;
        for ($extra = 1; $extra < $reminder->length; $extra++) {
            $extraDate = $this->addDay($extraDate);

            list($y, $m, $d) = $this->splitDate($extraDate);
            if (!$this->calendar->hasYearZero() && $y == 0) {
                $extraDate = '1-' . $m . '-' . $d;
            }
            $this->events[$extraDate][] = $reminder;
        }
        // Finished adding all the reminder's days, flag it to show (end) in the UI
        $this->eventEnd[$reminder->id][] = $extraDate;
    }

    /**
     * Add an extra day to a date.
     */
    protected function addDay(string $date): string
    {
        list($year, $month, $day) = $this->splitDate($date);
        $day++;

        // Day longer than month?
        $months = $this->calendar->months();
        $monthKey = max($month - 1, 0);
        // If we're showing a reminder from the parent calendar, but the month doesn't exist in this calendar,
        // we need to do this dirty hack where we fake the previous month as being the last month of the previous year
        if (!isset($months[$monthKey])) {
            $monthKey = count($months) - 1;
            //$year;
            $day = 999999; // Force it to the last day of the previous month so that it can be incremented by one
        }
        $currentMonth = $months[$monthKey];
        //$previousMonth = $month > 1 ? $months[$month-1] : last($months);
        if ($day > $currentMonth['length']) {
            $day = 1;
            $month++;
        }

        // Month longer than max year?
        if ($month > count($months)) {
            $month = 1;
            $year++;
        }

        return "{$year}-{$month}-{$day}";
    }

    /**
     */
    protected function subMonth(int $year, int $month): array
    {
        $months = $this->calendar->months();
        $month--;

        if ($month <= 0) {
            $month = count($months);
            $year--;
        }
        return [$year, $month];
    }

    /**
     * Get the current year
     */
    protected function getYear(?int $add = 0): int
    {
        if (!$this->calendar->hasYearZero() && $this->year == 0) {
            return intval($this->year + 1 + $add);
        }
        // We need intval for people asking for a number that is > 32bit converting to floats
        return intval((int) $this->year + $add);
    }

    /**
     * Get the current month
     */
    protected function getMonth(?int $add = 0): int
    {
        return intval($this->month + $add);
    }

    /**
     */
    protected function setYear(int $year): self
    {
        $this->year = $year;
        return $this;
    }

    /**
     */
    protected function setMonth(int $month): self
    {
        $this->month = $month;
        return $this;
    }

    /**
     * Split the date into segments. Handle negative years
     * @return array
     */
    protected function splitDate(string $date)
    {
        $segments = explode('-', ltrim($date, '-'));
        if (str_starts_with($date, '-')) {
            $segments[0] = '-' . $segments[0];
        }
        return $segments;
    }

    /**
     */
    public function isYearlyLayout(): bool
    {
        return $this->layout === 'year';
    }

    /**
     */
    public function currentYear(): int
    {
        return (int) $this->year;
    }

    /**
     */
    public function isNamedWeek(int $week): bool
    {
        return !empty($this->weeks[$week]) && !$this->isIntercalaryMonth();
    }

    /**
     */
    public function namedWeek(int $week): string
    {
        return $this->weeks[$week] . '';
    }

    /**
     *
     */
    protected function buildFullmoons(): void
    {
        //dump('full moons go brr');
        // Calculate the number of days since 0000-01-01
        $totalDays = $this->daysToDate();

        // We'll need this later to know how many full moons to add
        $daysInAYear = 0;
        foreach ($this->calendar->months() as $count => $month) {
            $length = $month['length'];
            $daysInAYear += $length;
        }
        foreach ($this->calendar->moons() as $moon) {
            $fullmoon = $moon['fullmoon'];
            // Let's figure out how many full moons occurred until now
            $numberOfFullMoons = $totalDays / $fullmoon;

            // When was the last full moon?
            $lastFullMoon = floor($numberOfFullMoons) * $fullmoon;

            // Use that to see how many days it's been
            $daysSinceLastFullMoon = round($totalDays - $lastFullMoon, 2);

            // Next full moon? If it's 0, we want it today.
            $nextFullMoon = (1 + $moon['offset']) + ($fullmoon - ($daysSinceLastFullMoon == 0 ? $fullmoon : $daysSinceLastFullMoon));

            // Previous cycles. Twice because sometimes the first full moon appears at the end of a long month, so
            // we need to fill up the month as much as we can.
            // With a big enough offset and fullmoon cycle, the user can end up with no moon on their first month of
            // the first year?
            $maxCycles = max(2, 3);
            for ($cycles = 1; $cycles <= $maxCycles; $cycles++) {
                $this->addMoonPhases($nextFullMoon - ($moon['fullmoon'] * $cycles), $moon);
            }

            // Current cycles
            $this->addMoonPhases($nextFullMoon, $moon);

            // Now the full moon will appear several times on this month/year.
            $fullMoonsPerYear = ceil($daysInAYear / $fullmoon);
            for ($i = 0; $i < $fullMoonsPerYear; $i++) {
                $nextFullMoon += $fullmoon;
                $this->addMoonPhases($nextFullMoon, $moon);
            }
        }
    }

    /**
     * Build the weather for the year
     */
    public function buildWeather(): void
    {
        // First build parent weather, and override with local weather
        if ($this->calendar->calendar) {
            $weathers = $this->calendar->calendar->calendarWeather()->year($this->currentYear())->get();

            /** @var CalendarWeather $weather */
            foreach ($weathers as $weather) {
                $this->weather[$weather->year . '-' . $weather->month . '-' . $weather->day] = $weather;
            }
        }

        $weathers = $this->calendar->calendarWeather()->year($this->currentYear())->get();

        /** @var CalendarWeather $weather */
        foreach ($weathers as $weather) {
            $this->weather[$weather->year . '-' . $weather->month . '-' . $weather->day] = $weather;
        }
    }

    /**
     * Get the total amount of days since the beginning
     * @return float|int|mixed
     */
    protected function daysToDate(bool $includeIntercalary = true)
    {
        // We assume that the 01 01 00 is a monday.
        // We need to know how many days elapsed since that day, to calculate the offset (total days / week length)

        $daysInAYear = $days = $leapDays = 0;
        foreach ($this->calendar->months() as $count => $month) {
            if (!$includeIntercalary && Arr::get($month, 'type') == 'intercalary') {
                continue;
            }
            $length = $month['length'];
            $daysInAYear += $length;

            // If the month has already passed, add it to the days for this year
            if ($count < $this->getMonth() - 1) {
                $days += $length;
            }
        }

        if ($this->calendar->has_leap_year && $this->getYear() >= $this->calendar->leap_year_start) {
            // If the leap month is intercalary, we don't need to offset anything.
            $months = $this->calendar->months();
            $leapMonth = Arr::get($months, $this->calendar->leap_year_month - 1, false);
            if ($leapMonth && Arr::get($leapMonth, 'type') == 'intercalary') {
                // Nothing
            } else {
                // Calc the number of years that were leap years
                //            dump("the current year (" . $this->getYear() . ") is >= to when the calendar leap year starts
                //               (" . $this->calendar->leap_year_start . ")");
                $yearDiffWithLeapStart = $this->getYear() - $this->calendar->leap_year_start;
                $amountOfYears = ceil($yearDiffWithLeapStart / $this->calendar->leap_year_offset);
                //            dump ("the amount of leap years that has elapsed since the beginning is the following: $amountOfYears");
                //            dump ("the value is ceil((" . $this->getYear() . "-" . $this->calendar->leap_year_start . ")
                //               / " . $this->calendar->leap_year_offset . ")");
                if ($amountOfYears < 0) {
                    $amountOfYears = 0;
                }

                $leapDays = $amountOfYears * $this->calendar->leap_year_amount;

                //            dump ("total leap days elapsed: $leapDays");

                // But if we are a leap year, we need to do the math
                if (($this->getYear() - $this->calendar->leap_year_start) % $this->calendar->leap_year_offset == 0) {
                    if ($this->getMonth() > $this->calendar->leap_year_month) {
                        // We've passed the leap month of the year
                        $leapDays += $this->calendar->leap_year_amount;
                    }
                }
            }
        }

        // Amount of days since the beginning of the year
        if (!$this->calendar->hasYearZero() && $this->getYear() > 0) {
            return ($daysInAYear * ($this->getYear() - 1)) + $days + $leapDays;
        }
        return ($daysInAYear * $this->getYear()) + $days + $leapDays;
    }

    /**
     */
    protected function addMoonPhases(float $start, array $moon): void
    {
        // Full & New Moon
        $this->addMoonPhase($start, $moon, 'full', 'far fa-circle');
        $newMoon = $start + ($moon['fullmoon'] / 2);
        $this->addMoonPhase($newMoon, $moon, 'new', 'fa-solid fa-circle');

        if ($moon['fullmoon'] <= 10) {
            return;
        }
        // Cycle is long enough for more phases to be displayed
        $quarterMonth = $moon['fullmoon'] / 4;
        $this->addMoonPhase($newMoon - $quarterMonth, $moon, 'last_quarter', 'fa-solid fa-circle-half-stroke fa-flip-horizontal');
        $this->addMoonPhase($newMoon + $quarterMonth, $moon, '1first_quarter', 'fa-solid fa-circle-half-stroke');
    }

    /**
     */
    protected function addMoonPhase(float $nextFullMoon, array $moon, string $type = 'full', string $class = 'fa-regular fa-circle'): void
    {
        // Moons can be float so we "floor" them
        $nextFullMoon = floor($nextFullMoon);

        // If the next full moon is before year 0... What?
        if ($nextFullMoon < 0) {
            //return;
        }
        if (!isset($this->moons[$nextFullMoon])) {
            $this->moons[$nextFullMoon] = [];
        }
        $this->moons[$nextFullMoon][] = [
            'name' => $moon['name'],
            'type' => $type,
            'class' => $class,
            'colour' => $this->moonColour(Arr::get($moon, 'colour', 'grey')),
            'id' => Arr::get($moon, 'id', null)
        ];
    }

    protected function moonColour(string $colour): string
    {
        switch ($colour) {
            case 'aqua':
                return 'blue-500';
            case 'black':
                return 'black';
            case 'brown':
                return 'orange-900';
                /*case 'green':
                    return 'green-500';*/
            case 'light-blue':
                return 'blue-300';
            case 'maroon':
                return 'pink-800';
            case 'navy':
                return 'blue-900';
                /*case 'orange':
                    return 'orange-500';
                case 'pink':
                    return 'pink-500';
                case 'purple':
                    return 'purple-500';
                case 'red':
                    return 'red-500';
                case 'teal':
                    return 'teal-500';
                case 'yellow':
                    return 'yellow-500';*/
            case 'grey':
                return 'gray-500';
        }
        return $colour . '-500';
    }

    /**
     * Prepare each of the calendar's seasons
     */
    protected function buildSeasons(): void
    {
        foreach ($this->calendar->seasons() as $season) {
            $date = $season['month'] . '-' . $season['day'];
            $this->seasons[$date] = $season['name'];
        }
    }

    /**
     * Prepare each of the calendar's yearly weeks
     */
    protected function buildWeeks(): void
    {
        foreach ($this->calendar->weeks() as $number => $week) {
            if ($number <= 0) {
                continue;
            }
            $this->weeks[$number] = $week;
        }
    }

    /**
     * Calculate the starting week number
     */
    protected function startingWeekNumber(): int
    {
        $months = $this->calendar->months();
        $weekdays = $this->calendar->weekdays();
        $daysInAYear = 0;
        $weekNumber = 1;
        $weekdaysCount = count($weekdays);

        foreach ($months as $monthNumber => $monthData) {
            // If we've reached the current month, break
            if ($monthNumber == $this->getMonth() - 1) {
                break;
            }
            if (Arr::get($monthData, 'type') == 'intercalary') {
                continue;
            }

            // If we reset months on the week, we need
            if ($this->calendar->reset === 'month') {
                //dump('month ' . $monthNumber . ' resets. length: ' . $monthData['length'] . ' / ' . $weekdaysCount . ' + 1');
                //dump('reset, adding ' . (ceil($monthData['length'] / $weekdaysCount)) . ' week');
                $weekNumber += ceil($monthData['length'] / $weekdaysCount) ;
            }
            $daysInAYear += $monthData['length'];
        }


        // If we reset months on the week, we need
        if ($this->calendar->reset === 'month') {
            return $weekNumber;
        }

        // We have the total number of days from the previous months, so we can figure out when the current
        // week starts
        $weekNumber = floor($daysInAYear / $weekdaysCount) + 1;

        return (int) $weekNumber;
    }

    /**
     * Get the number of days since the beginning of the year. This is used to calculate the month start offset on
     * calendars with first days resetting on the year.
     */
    protected function daysToDateForYear(): int
    {
        $offset = 0;

        $daysInAYear = $days = $leapDays = 0;
        foreach ($this->calendar->months() as $count => $month) {
            if (Arr::get($month, 'type') == 'intercalary') {
                continue;
            }
            $length = $month['length'];
            $daysInAYear += $length;

            // If the month has already passed, add it to the days for this year
            if ($count < $this->getMonth() - 1) {
                $days += $length;
            }
        }

        return $days;
    }

    /**
     * Checks if date is the start of an event
     */
    public function isEventStartDate(EntityEvent $event, string $date): bool
    {
        return isset($this->eventStart[$event->id]) && in_array($date, $this->eventStart[$event->id]);
    }

    /**
     * Checks if date is the end of an event
     */
    public function isEventEndDate(EntityEvent $event, string $date): bool
    {
        return isset($this->eventEnd[$event->id]) && in_array($date, $this->eventEnd[$event->id]);
    }
}
