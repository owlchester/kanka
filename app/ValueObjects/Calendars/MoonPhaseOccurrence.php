<?php

namespace App\ValueObjects\Calendars;

final readonly class MoonPhaseOccurrence
{
    /** @param list<string> $exactPhases */
    public function __construct(
        public int $moonId,
        public string $name,
        public string $colour,
        public string $phase,
        public CalendarDate $date,
        public int $ordinal,
        public array $exactPhases = [],
    ) {}
}
