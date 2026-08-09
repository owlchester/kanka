<?php

namespace App\Services\Calendars;

use App\ValueObjects\Calendars\CalendarDate;
use App\ValueObjects\Calendars\Occurrence;
use App\ValueObjects\Calendars\RecurrenceRule;
use InvalidArgumentException;

final class OccurrenceEngine
{
    public function __construct(private readonly CalendarChronology $chronology) {}

    /**
     * Generate occurrences intersecting an inclusive date window.
     *
     * @return list<Occurrence>
     */
    public function occurrences(
        CalendarDate $anchor,
        int $length,
        ?RecurrenceRule $rule,
        CalendarDate $from,
        CalendarDate $to,
    ): array {
        if ($length < 1 || $from->compare($to) > 0) {
            throw new InvalidArgumentException('Invalid occurrence range.');
        }
        if (! $this->chronology->isValid($anchor)
            || ! $this->chronology->isValid($from)
            || ! $this->chronology->isValid($to)) {
            throw new InvalidArgumentException('Occurrence dates must be valid calendar dates.');
        }

        if ($rule === null) {
            $occurrence = $this->makeOccurrence($anchor, $length, 0, $from, $to);

            return $occurrence === null ? [] : [$occurrence];
        }

        return match ($rule->frequency) {
            RecurrenceRule::DAILY, RecurrenceRule::WEEKLY => $this->fixedDayOccurrences($anchor, $length, $rule, $from, $to),
            RecurrenceRule::MONTHLY => $this->monthlyOccurrences($anchor, $length, $rule, $from, $to),
            RecurrenceRule::YEARLY => $this->yearlyOccurrences($anchor, $length, $rule, $from, $to),
            RecurrenceRule::MOON_PHASE => $this->moonOccurrences($anchor, $length, $rule, $from, $to),
            default => throw new InvalidArgumentException('Unsupported recurrence frequency.'),
        };
    }

    /** @return list<Occurrence> */
    private function fixedDayOccurrences(CalendarDate $anchor, int $length, RecurrenceRule $rule, CalendarDate $from, CalendarDate $to): array
    {
        $step = $rule->frequency === RecurrenceRule::WEEKLY
            ? $rule->interval * $this->chronology->definition()->weekdayCount()
            : $rule->interval;
        $anchorOrdinal = $this->chronology->toOrdinal($anchor);
        $firstOrdinal = $this->chronology->toOrdinal($from) - ($length - 1);
        $sequence = max(0, self::ceilDiv($firstOrdinal - $anchorOrdinal, $step));
        $occurrences = [];

        while (true) {
            $candidate = $this->chronology->fromOrdinal($anchorOrdinal + ($sequence * $step));
            if ($this->pastUntil($candidate, $rule) || $candidate->compare($to) > 0) {
                break;
            }
            $occurrence = $this->makeOccurrence($candidate, $length, $sequence, $from, $to);
            if ($occurrence !== null) {
                $occurrences[] = $occurrence;
            }
            $sequence++;
        }

        return $occurrences;
    }

    /** @return list<Occurrence> */
    private function monthlyOccurrences(CalendarDate $anchor, int $length, RecurrenceRule $rule, CalendarDate $from, CalendarDate $to): array
    {
        $targetSerial = $this->chronology->toOrdinal($from);
        $monthDistance = $this->monthSerial($from) - $this->monthSerial($anchor);
        $sequence = max(0, self::ceilDiv($monthDistance, $rule->interval));
        if ($this->chronology->toOrdinal($anchor) + $length - 1 >= $targetSerial) {
            $sequence = 0;
        }
        $occurrences = [];

        while (true) {
            if ($this->monthSerial($anchor) + ($sequence * $rule->interval) > $this->monthSerial($to)) {
                break;
            }
            $candidate = $this->chronology->addMonths($anchor, $sequence * $rule->interval, $rule->invalidDate);
            if ($candidate === null) {
                $sequence++;

                continue;
            }
            if ($this->pastUntil($candidate, $rule) || $candidate->compare($to) > 0) {
                break;
            }
            if ($this->chronology->toOrdinal($candidate) + $length - 1 >= $targetSerial) {
                $occurrence = $this->makeOccurrence($candidate, $length, $sequence, $from, $to);
                if ($occurrence !== null) {
                    $occurrences[] = $occurrence;
                }
            }
            $sequence++;
        }

        return $occurrences;
    }

    /** @return list<Occurrence> */
    private function yearlyOccurrences(CalendarDate $anchor, int $length, RecurrenceRule $rule, CalendarDate $from, CalendarDate $to): array
    {
        $yearDistance = $this->yearSerial($from->year) - $this->yearSerial($anchor->year);
        $sequence = max(0, self::ceilDiv($yearDistance, $rule->interval));
        if ($this->chronology->toOrdinal($anchor) + $length - 1 >= $this->chronology->toOrdinal($from)) {
            $sequence = 0;
        }
        $occurrences = [];

        while (true) {
            if ($this->yearSerial($anchor->year) + ($sequence * $rule->interval) > $this->yearSerial($to->year)) {
                break;
            }
            $candidate = $this->chronology->addYears($anchor, $sequence * $rule->interval, $rule->invalidDate);
            if ($candidate === null) {
                $sequence++;

                continue;
            }
            if ($this->pastUntil($candidate, $rule) || $candidate->compare($to) > 0) {
                break;
            }
            $occurrence = $this->makeOccurrence($candidate, $length, $sequence, $from, $to);
            if ($occurrence !== null) {
                $occurrences[] = $occurrence;
            }
            $sequence++;
        }

        return $occurrences;
    }

    /** @return list<Occurrence> */
    private function moonOccurrences(CalendarDate $anchor, int $length, RecurrenceRule $rule, CalendarDate $from, CalendarDate $to): array
    {
        $moon = collect($this->chronology->definition()->moons)->firstWhere('id', $rule->moonId);
        if (! is_array($moon) || (float) ($moon['fullmoon'] ?? 0) <= 0) {
            throw new InvalidArgumentException("Unknown moon: {$rule->moonId}");
        }

        $cycle = (float) $moon['fullmoon'];
        $phaseOffset = $rule->phase === 'new' ? $cycle / 2 : 0;
        $start = $this->chronology->toOrdinal($from) - ($length - 1);
        $end = $this->chronology->toOrdinal($to);
        $anchorOrdinal = $this->chronology->toOrdinal($anchor);
        $firstCycle = (int) floor(($start - (float) ($moon['offset'] ?? 0) - $phaseOffset) / $cycle) - 1;
        $lastCycle = (int) ceil(($end - (float) ($moon['offset'] ?? 0) - $phaseOffset) / $cycle) + 1;
        $occurrences = [];
        $sequence = 0;
        $seen = [];

        for ($cycleNumber = $firstCycle; $cycleNumber <= $lastCycle; $cycleNumber++) {
            $ordinal = (int) floor((float) ($moon['offset'] ?? 0) + $phaseOffset + ($cycleNumber * $cycle));
            if ($ordinal < $anchorOrdinal || isset($seen[$ordinal])) {
                continue;
            }
            $seen[$ordinal] = true;
            $candidate = $this->chronology->fromOrdinal($ordinal);
            if ($this->pastUntil($candidate, $rule) || $candidate->compare($to) > 0) {
                continue;
            }
            $occurrence = $this->makeOccurrence($candidate, $length, $sequence++, $from, $to);
            if ($occurrence !== null) {
                $occurrences[] = $occurrence;
            }
        }

        usort($occurrences, static fn (Occurrence $a, Occurrence $b): int => $a->start->compare($b->start));

        return $occurrences;
    }

    private function makeOccurrence(CalendarDate $start, int $length, int $sequence, CalendarDate $from, CalendarDate $to): ?Occurrence
    {
        $end = $this->chronology->addDays($start, $length - 1);
        if ($end->compare($from) < 0 || $start->compare($to) > 0) {
            return null;
        }

        return new Occurrence($start, $end, $sequence);
    }

    private function pastUntil(CalendarDate $date, RecurrenceRule $rule): bool
    {
        return $rule->untilYear !== null && $date->year > $rule->untilYear;
    }

    private function monthSerial(CalendarDate $date): int
    {
        $yearSerial = $this->yearSerial($date->year);

        return $yearSerial * $this->chronology->definition()->monthCount() + $date->month - 1;
    }

    private function yearSerial(int $year): int
    {
        if ($this->chronology->definition()->hasYearZero) {
            return $year;
        }

        return $year > 0 ? $year - 1 : $year;
    }

    private static function ceilDiv(int $numerator, int $denominator): int
    {
        if ($numerator >= 0) {
            return intdiv($numerator + $denominator - 1, $denominator);
        }

        return -intdiv(-$numerator, $denominator);
    }
}
