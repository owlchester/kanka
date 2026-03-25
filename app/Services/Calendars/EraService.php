<?php

namespace App\Services\Calendars;

use App\Models\CalendarEra;
use App\Traits\CalendarAware;

class EraService
{
    use CalendarAware;

    /** @var CalendarEra[] */
    protected array $eras = [];

    public function build(): void
    {
        $this->eras = $this->calendar->calendarEras()
            ->orderBy('start_year')
            ->orderBy('start_month')
            ->orderBy('start_day')
            ->get()
            ->all();
    }

    /**
     * @return CalendarEra[]
     */
    public function all(): array
    {
        return $this->eras;
    }

    /**
     * Check if a specific date is the start of any era
     */
    public function isEraStart(int $year, int $month, int $day): ?CalendarEra
    {
        foreach ($this->eras as $era) {
            if ($era->start_year === $year && $era->startMonth() === $month && $era->startDay() === $day) {
                return $era;
            }
        }

        return null;
    }

    /**
     * Check if a specific date is the end of any era
     */
    public function isEraEnd(int $year, int $month, int $day): ?CalendarEra
    {
        foreach ($this->eras as $era) {
            if ($era->hasEndDate() && $era->end_year === $year && $era->endMonth() === $month && $era->endDay() === $day) {
                return $era;
            }
        }

        return null;
    }

    /**
     * Find the active era for a given date
     */
    public function activeEra(int $year, int $month, int $day): ?CalendarEra
    {
        foreach ($this->eras as $era) {
            if ($era->containsDate($year, $month, $day)) {
                return $era;
            }
        }

        return null;
    }
}
