<?php

namespace App\ValueObjects\Calendars;

final readonly class MoonState
{
    /** @param list<string> $exactPhases */
    public function __construct(
        public int $moonId,
        public string $name,
        public string $colour,
        public string $phase,
        public CalendarDate $phaseDate,
        public int $daysSincePhase,
        public array $exactPhases = [],
    ) {}

    public function isExact(): bool
    {
        return $this->daysSincePhase === 0;
    }
}
