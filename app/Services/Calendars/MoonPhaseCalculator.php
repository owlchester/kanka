<?php

namespace App\Services\Calendars;

use App\ValueObjects\Calendars\CalendarDate;
use App\ValueObjects\Calendars\MoonPhaseOccurrence;
use App\ValueObjects\Calendars\MoonState;
use InvalidArgumentException;

final class MoonPhaseCalculator
{
    private const SCALE = 10000000000;

    /** @var array<string, int> */
    private const PHASES = [
        'full' => 0,
        'last_quarter' => 1,
        'new' => 2,
        'first_quarter' => 3,
    ];

    public function __construct(private readonly CalendarChronology $chronology) {}

    /** @return list<MoonState> */
    public function statesAt(CalendarDate $date): array
    {
        $ordinal = $this->chronology->toOrdinal($date);
        $states = [];

        foreach ($this->chronology->definition()->moons as $moon) {
            $id = (int) ($moon['id'] ?? 0);
            $cycle = $this->decimalTicks($moon['fullmoon'] ?? 0);
            if ($id < 1 || $cycle <= 0) {
                continue;
            }

            $latest = $this->latestPhase($moon, $ordinal, $cycle);
            $states[] = new MoonState(
                $id,
                (string) ($moon['name'] ?? ''),
                $this->colour((string) ($moon['colour'] ?? 'grey')),
                $latest->phase,
                $latest->date,
                $ordinal - $latest->ordinal,
                $latest->exactPhases,
            );
        }

        return $states;
    }

    /** @return list<MoonPhaseOccurrence> */
    public function phasesBetween(CalendarDate $from, CalendarDate $to): array
    {
        $fromOrdinal = $this->chronology->toOrdinal($from);
        $toOrdinal = $this->chronology->toOrdinal($to);
        if ($fromOrdinal > $toOrdinal) {
            throw new InvalidArgumentException('Moon phase range is invalid.');
        }

        $phases = [];
        foreach ($this->chronology->definition()->moons as $moon) {
            $id = (int) ($moon['id'] ?? 0);
            $cycle = $this->decimalTicks($moon['fullmoon'] ?? 0);
            if ($id < 1 || $cycle <= 0) {
                continue;
            }

            foreach (self::PHASES as $phase => $phaseIndex) {
                $phaseCount = count(self::PHASES);
                $denominator = $phaseCount * self::SCALE;
                $base = $this->decimalTicks($moon['offset'] ?? 0) * $phaseCount;
                $step = $cycle * $phaseCount;
                $phaseBase = $base + ($phaseIndex * $cycle);
                $firstCycle = self::ceilDiv($fromOrdinal * $denominator - $phaseBase, $step);
                $lastCycle = self::floorDiv((($toOrdinal + 1) * $denominator - 1) - $phaseBase, $step);

                for ($cycleNumber = $firstCycle; $cycleNumber <= $lastCycle; $cycleNumber++) {
                    $ordinal = self::floorDiv($phaseBase + ($cycleNumber * $step), $denominator);
                    $date = $this->chronology->fromOrdinal($ordinal);
                    $phases[] = new MoonPhaseOccurrence(
                        $id,
                        (string) ($moon['name'] ?? ''),
                        $this->colour((string) ($moon['colour'] ?? 'grey')),
                        $phase,
                        $date,
                        $ordinal,
                        [$phase],
                    );
                }
            }
        }

        usort($phases, static fn (MoonPhaseOccurrence $a, MoonPhaseOccurrence $b): int => $a->ordinal <=> $b->ordinal);

        return $this->mergeExactPhases($phases);
    }

    /** @param array<string, mixed> $moon */
    private function latestPhase(array $moon, int $ordinal, int $cycle): MoonPhaseOccurrence
    {
        $phaseCount = count(self::PHASES);
        $denominator = $phaseCount * self::SCALE;
        $offset = $this->decimalTicks($moon['offset'] ?? 0);
        $step = $cycle * $phaseCount;
        $latest = null;
        $latestBoundary = null;

        foreach (self::PHASES as $phase => $phaseIndex) {
            $phaseBase = $offset * $phaseCount + ($phaseIndex * $cycle);
            $cycleNumber = self::floorDiv($ordinal * $denominator - $phaseBase, $step);
            $boundary = $phaseBase + ($cycleNumber * $step);
            $phaseOrdinal = self::floorDiv($boundary, $denominator);
            if ($phaseOrdinal > $ordinal) {
                $cycleNumber--;
                $boundary -= $step;
                $phaseOrdinal = self::floorDiv($boundary, $denominator);
            }

            if ($latest === null || $phaseOrdinal > $latest->ordinal || ($phaseOrdinal === $latest->ordinal && $boundary > $latestBoundary)) {
                $latest = new MoonPhaseOccurrence(
                    (int) ($moon['id'] ?? 0),
                    (string) ($moon['name'] ?? ''),
                    $this->colour((string) ($moon['colour'] ?? 'grey')),
                    $phase,
                    $this->chronology->fromOrdinal($phaseOrdinal),
                    $phaseOrdinal,
                    [$phase],
                );
                $latestBoundary = $boundary;
            }
        }

        $exact = [];
        foreach (self::PHASES as $phase => $phaseIndex) {
            $phaseBase = $offset * $phaseCount + ($phaseIndex * $cycle);
            $cycleNumber = self::floorDiv($ordinal * $denominator - $phaseBase, $step);
            $phaseOrdinal = self::floorDiv($phaseBase + ($cycleNumber * $step), $denominator);
            if ($phaseOrdinal === $latest->ordinal) {
                $exact[] = $phase;
            }
        }

        return new MoonPhaseOccurrence(
            $latest->moonId,
            $latest->name,
            $latest->colour,
            $latest->phase,
            $latest->date,
            $latest->ordinal,
            $exact,
        );
    }

    /** @param list<MoonPhaseOccurrence> $phases */
    /** @return list<MoonPhaseOccurrence> */
    private function mergeExactPhases(array $phases): array
    {
        $merged = [];
        foreach ($phases as $phase) {
            $key = $phase->moonId . ':' . $phase->ordinal;
            if (! isset($merged[$key])) {
                $merged[$key] = $phase;

                continue;
            }
            $existing = $merged[$key];
            $merged[$key] = new MoonPhaseOccurrence(
                $existing->moonId,
                $existing->name,
                $existing->colour,
                $existing->phase,
                $existing->date,
                $existing->ordinal,
                [...$existing->exactPhases, $phase->phase],
            );
        }

        return array_values($merged);
    }

    private function decimalTicks(float|int|string $value): int
    {
        $value = trim((string) $value);
        if (! preg_match('/^-?\d+(?:\.\d{1,10})?$/', $value)) {
            throw new InvalidArgumentException("Invalid moon cycle value: {$value}");
        }

        $negative = str_starts_with($value, '-');
        $value = ltrim($value, '-');
        [$whole, $fraction] = array_pad(explode('.', $value, 2), 2, '');
        $ticks = ((int) $whole * self::SCALE) + (int) str_pad($fraction, 10, '0');

        return $negative ? -$ticks : $ticks;
    }

    private function colour(string $colour): string
    {
        return match ($colour) {
            'aqua' => '#3B82F6',
            'black' => '#000000',
            'brown' => '#7C2D12',
            'green' => '#22C55E',
            'light-blue' => '#93C5FD',
            'maroon' => '#9D174D',
            'navy' => '#1E3A8A',
            'orange' => '#F97316',
            'pink' => '#EC4899',
            'purple' => '#A855F7',
            'red' => '#EF4444',
            'teal' => '#14B8A6',
            'yellow' => '#EAB308',
            'grey' => '#6B7280',
            default => $colour,
        };
    }

    private static function floorDiv(int $numerator, int $denominator): int
    {
        if ($numerator >= 0) {
            return intdiv($numerator, $denominator);
        }

        return -intdiv(-$numerator + $denominator - 1, $denominator);
    }

    private static function ceilDiv(int $numerator, int $denominator): int
    {
        return -self::floorDiv(-$numerator, $denominator);
    }
}
