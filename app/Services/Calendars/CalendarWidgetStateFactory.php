<?php

namespace App\Services\Calendars;

use App\Models\Calendar;
use App\ValueObjects\Calendars\CalendarDate;
use App\ValueObjects\Calendars\CalendarWidgetState;

final class CalendarWidgetStateFactory
{
    public function __construct(private readonly ReminderService $reminders) {}

    public function make(Calendar $calendar): CalendarWidgetState
    {
        $date = new CalendarDate($calendar->currentYear(), $calendar->currentMonth(), $calendar->currentDay());
        $chronology = $calendar->chronology();
        $window = $this->reminders->calendar($calendar)->around(5);
        $weather = $calendar->calendarWeather()
            ->year($date->year)
            ->month($date->month)
            ->where('day', $date->day)
            ->first();
        $weekdays = $calendar->weekdays();

        return new CalendarWidgetState(
            $window->past,
            $window->upcoming,
            (new MoonPhaseCalculator($chronology))->statesAt($date),
            $weekdays[$chronology->weekdayIndex($date)] ?? null,
            $weather,
        );
    }
}
