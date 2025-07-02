<?php

namespace App\Services\Calendars;

use App\Traits\CalendarAware;

class SeasonService
{
    use CalendarAware;

    protected array $seasons = [];

    public function has(string $day): bool
    {
        return isset($this->seasons[$day]);
    }

    public function get(string $day): array
    {
        return $this->seasons[$day] ?? [];
    }

    public function build(): void
    {
        foreach ($this->calendar->seasons() as $season) {
            $date = $season['month'] . '-' . $season['day'];
            $this->seasons[$date] = $season['name'];
        }
    }
}
