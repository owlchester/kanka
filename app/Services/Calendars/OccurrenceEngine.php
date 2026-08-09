<?php

namespace App\Services\Calendars;

use App\ValueObjects\Calendars\CalendarDate;
use App\ValueObjects\Calendars\Occurrence;
use App\ValueObjects\Calendars\RecurrenceRule;
use InvalidArgumentException;

final class OccurrenceEngine
{
    private readonly MoonPhaseCalculator $moonPhases;

    public function __construct(
        private readonly CalendarChronology $chronology,
        ?MoonPhaseCalculator $moonPhases = null,
    ) {
        $this->moonPhases = $moonPhases ?? new MoonPhaseCalculator($chronology);
    }

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
        $earliestStart = $this->chronology->fromOrdinal($this->chronology->toOrdinal($from) - ($length - 1));
        $targetSerial = $this->chronology->toOrdinal($earliestStart);
        $monthDistance = $this->monthSerial($earliestStart) - $this->monthSerial($anchor);
        $sequence = max(0, self::ceilDiv($monthDistance, $rule->interval));
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
            $occurrence = $this->makeOccurrence($candidate, $length, $sequence, $from, $to);
            if ($occurrence !== null) {
                $occurrences[] = $occurrence;
            }
            $sequence++;
        }

        return $occurrences;
    }

    /** @return list<Occurrence> */
    private function yearlyOccurrences(CalendarDate $anchor, int $length, RecurrenceRule $rule, CalendarDate $from, CalendarDate $to): array
    {
        $earliestStart = $this->chronology->fromOrdinal($this->chronology->toOrdinal($from) - ($length - 1));
        $yearDistance = $this->yearSerial($earliestStart->year) - $this->yearSerial($anchor->year);
        $sequence = max(0, self::ceilDiv($yearDistance, $rule->interval));
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

        $anchorOrdinal = $this->chronology->toOrdinal($anchor);
        $occurrences = [];
        $sequence = 0;

        $earliestStart = $this->chronology->fromOrdinal($this->chronology->toOrdinal($from) - ($length - 1));
        foreach ($this->moonPhases->phasesBetween($earliestStart, $to) as $phase) {
            if ($phase->moonId !== $rule->moonId || ! in_array($rule->phase, $phase->exactPhases, true) || $phase->ordinal < $anchorOrdinal) {
                continue;
            }
            $candidate = $phase->date;
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

    public function nextOrActiveOccurrence(
        CalendarDate $anchor,
        int $length,
        ?RecurrenceRule $rule,
        CalendarDate $pivot,
    ): ?Occurrence {
        $this->validate($anchor, $length, $pivot);
        $pivotOrdinal = $this->chronology->toOrdinal($pivot);

        if ($rule === null) {
            return $this->occurrenceIf($anchor, $length, static fn (Occurrence $occurrence): bool => $occurrence->end->compare($pivot) >= 0);
        }

        if ($rule->frequency === RecurrenceRule::MOON_PHASE) {
            $earliestStart = $this->chronology->fromOrdinal($pivotOrdinal - ($length - 1));
            foreach ($this->moonPhases->phasesBetween($earliestStart, $this->chronology->fromOrdinal($pivotOrdinal + $this->searchLimit($rule))) as $phase) {
                if ($phase->moonId === $rule->moonId && in_array($rule->phase, $phase->exactPhases, true)) {
                    $occurrence = $this->buildOccurrence($phase->date, $length, 0);
                    if (! $this->pastUntil($occurrence->start, $rule) && $occurrence->end->compare($pivot) >= 0 && $occurrence->start->compare($anchor) >= 0) {
                        return $occurrence;
                    }
                }
            }

            return null;
        }

        $sequence = $this->firstSequenceAtOrAfter($anchor, $length, $rule, $pivot, false);
        for ($attempt = 0; $attempt < 100000; $attempt++) {
            $candidate = $this->candidateAt($anchor, $rule, $sequence);
            if ($candidate === null) {
                $sequence++;

                continue;
            }
            if ($this->pastUntil($candidate, $rule)) {
                return null;
            }
            $occurrence = $this->buildOccurrence($candidate, $length, $sequence);
            if ($occurrence->end->compare($pivot) >= 0) {
                return $occurrence;
            }
            $sequence++;
        }

        return null;
    }

    public function previousOccurrence(
        CalendarDate $anchor,
        int $length,
        ?RecurrenceRule $rule,
        CalendarDate $pivot,
    ): ?Occurrence {
        $this->validate($anchor, $length, $pivot);
        $pivotOrdinal = $this->chronology->toOrdinal($pivot);

        if ($rule === null) {
            return $this->occurrenceIf($anchor, $length, static fn (Occurrence $occurrence): bool => $occurrence->end->compare($pivot) < 0);
        }

        if ($rule->frequency === RecurrenceRule::MOON_PHASE) {
            $end = $this->chronology->fromOrdinal($pivotOrdinal - $length);
            $phases = $this->moonPhases->phasesBetween($this->chronology->fromOrdinal($pivotOrdinal - $this->searchLimit($rule)), $end);
            foreach (array_reverse($phases) as $phase) {
                if ($phase->moonId !== $rule->moonId || ! in_array($rule->phase, $phase->exactPhases, true) || $phase->ordinal < $this->chronology->toOrdinal($anchor)) {
                    continue;
                }
                $occurrence = $this->buildOccurrence($phase->date, $length, 0);
                if (! $this->pastUntil($occurrence->start, $rule) && $occurrence->end->compare($pivot) < 0) {
                    return $occurrence;
                }
            }

            return null;
        }

        $sequence = $this->firstSequenceAtOrAfter($anchor, $length, $rule, $pivot, true);
        for (; $sequence >= 0; $sequence--) {
            $candidate = $this->candidateAt($anchor, $rule, $sequence);
            if ($candidate === null) {
                continue;
            }
            if ($this->pastUntil($candidate, $rule)) {
                continue;
            }
            $occurrence = $this->buildOccurrence($candidate, $length, $sequence);
            if ($occurrence->end->compare($pivot) < 0) {
                return $occurrence;
            }
        }

        return null;
    }

    private function makeOccurrence(CalendarDate $start, int $length, int $sequence, CalendarDate $from, CalendarDate $to): ?Occurrence
    {
        $end = $this->chronology->addDays($start, $length - 1);
        if ($end->compare($from) < 0 || $start->compare($to) > 0) {
            return null;
        }

        return new Occurrence($start, $end, $sequence);
    }

    private function buildOccurrence(CalendarDate $start, int $length, int $sequence): Occurrence
    {
        return new Occurrence($start, $this->chronology->addDays($start, $length - 1), $sequence);
    }

    private function occurrenceIf(CalendarDate $start, int $length, callable $predicate): ?Occurrence
    {
        $occurrence = $this->buildOccurrence($start, $length, 0);

        return $predicate($occurrence) ? $occurrence : null;
    }

    private function validate(CalendarDate $anchor, int $length, CalendarDate $pivot): void
    {
        if ($length < 1 || ! $this->chronology->isValid($anchor) || ! $this->chronology->isValid($pivot)) {
            throw new InvalidArgumentException('Occurrence dates must be valid calendar dates.');
        }
    }

    private function firstSequenceAtOrAfter(CalendarDate $anchor, int $length, RecurrenceRule $rule, CalendarDate $pivot, bool $past): int
    {
        $target = $this->chronology->fromOrdinal($this->chronology->toOrdinal($pivot) + ($past ? -$length : -($length - 1)));

        return match ($rule->frequency) {
            RecurrenceRule::DAILY => max(0, self::floorDiv($this->chronology->toOrdinal($target) - $this->chronology->toOrdinal($anchor), $rule->interval)),
            RecurrenceRule::WEEKLY => max(0, self::floorDiv($this->chronology->toOrdinal($target) - $this->chronology->toOrdinal($anchor), $rule->interval * $this->chronology->definition()->weekdayCount())),
            RecurrenceRule::MONTHLY => max(0, self::floorDiv($this->monthSerial($target) - $this->monthSerial($anchor), $rule->interval)),
            RecurrenceRule::YEARLY => max(0, self::floorDiv($this->yearSerial($target->year) - $this->yearSerial($anchor->year), $rule->interval)),
            default => 0,
        };
    }

    private function candidateAt(CalendarDate $anchor, RecurrenceRule $rule, int $sequence): ?CalendarDate
    {
        return match ($rule->frequency) {
            RecurrenceRule::DAILY => $this->chronology->addDays($anchor, $sequence * $rule->interval),
            RecurrenceRule::WEEKLY => $this->chronology->addDays($anchor, $sequence * $rule->interval * $this->chronology->definition()->weekdayCount()),
            RecurrenceRule::MONTHLY => $this->chronology->addMonths($anchor, $sequence * $rule->interval, $rule->invalidDate),
            RecurrenceRule::YEARLY => $this->chronology->addYears($anchor, $sequence * $rule->interval, $rule->invalidDate),
            default => null,
        };
    }

    private function searchLimit(RecurrenceRule $rule): int
    {
        if ($rule->frequency !== RecurrenceRule::MOON_PHASE) {
            return 0;
        }

        foreach ($this->chronology->definition()->moons as $moon) {
            if ((int) ($moon['id'] ?? 0) === $rule->moonId) {
                return max(2, (int) ceil(((float) ($moon['fullmoon'] ?? 1)) * 2));
            }
        }

        return 1000;
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

    private static function floorDiv(int $numerator, int $denominator): int
    {
        if ($numerator >= 0) {
            return intdiv($numerator, $denominator);
        }

        return -intdiv(-$numerator + $denominator - 1, $denominator);
    }
}
