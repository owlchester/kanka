<?php

namespace App\ValueObjects\Calendars;

use App\Models\CalendarWeather;
use Illuminate\Support\Collection;

final readonly class CalendarWidgetState
{
    /** @param Collection<int, ReminderOccurrence> $previousEvents */
    /** @param Collection<int, ReminderOccurrence> $upcomingEvents */
    /** @param list<MoonState> $currentMoons */
    public function __construct(
        public Collection $previousEvents,
        public Collection $upcomingEvents,
        public array $currentMoons,
        public ?string $currentWeekdayName,
        public ?CalendarWeather $weather,
    ) {}
}
