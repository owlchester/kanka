<?php

namespace App\Services\Calendars;

use App\Traits\CalendarAware;
use App\ValueObjects\Calendars\CalendarDate;

class MoonService
{
    use CalendarAware;

    /** @var array<int, list<array<string, mixed>>> */
    protected array $moons = [];

    public function has(int $ordinal): bool
    {
        return isset($this->moons[$ordinal]);
    }

    /** @return list<array<string, mixed>> */
    public function get(int $ordinal): array
    {
        return $this->moons[$ordinal] ?? [];
    }

    /**
     * Compatibility wrapper for callers that provide an ordinal and a year length.
     */
    public function build(int $totalDays, int $daysInAYear): void
    {
        $from = $this->calendar->chronology()->fromOrdinal($totalDays);
        $to = $this->calendar->chronology()->fromOrdinal($totalDays + max(0, $daysInAYear - 1));

        $this->buildForRange($from, $to);
    }

    public function buildForRange(CalendarDate $from, CalendarDate $to): void
    {
        $this->moons = [];
        $calculator = new MoonPhaseCalculator($this->calendar->chronology());

        foreach ($calculator->phasesBetween($from, $to) as $phase) {
            $this->moons[$phase->ordinal][] = [
                'name' => $phase->name,
                'type' => MoonPhase::displayKey($phase->phase),
                'phase' => $phase->phase,
                'class' => $this->phaseClass($phase->phase),
                'colour' => $phase->colour,
                'id' => $phase->moonId,
            ];
        }
    }

    private function phaseClass(string $phase): string
    {
        return 'moon-phase moon-phase-' . $phase;
    }
}
