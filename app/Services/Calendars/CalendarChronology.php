<?php

namespace App\Services\Calendars;

use App\ValueObjects\Calendars\CalendarDate;
use App\ValueObjects\Calendars\CalendarDefinition;
use App\ValueObjects\Calendars\LeapRule;
use InvalidArgumentException;

final class CalendarChronology
{
    public function __construct(private readonly CalendarDefinition $definition) {}

    public function definition(): CalendarDefinition
    {
        return $this->definition;
    }

    public function isLeapYear(int $year): bool
    {
        foreach ($this->definition->leapRules as $rule) {
            if ($rule->appliesTo($year)) {
                return true;
            }
        }

        return false;
    }

    public function isValid(CalendarDate $date): bool
    {
        if (! $this->definition->hasYearZero && $date->year === 0) {
            return false;
        }

        return $date->month <= $this->definition->monthCount()
            && $date->day <= $this->daysInMonth($date->year, $date->month);
    }

    public function daysInMonth(int $year, int $month): int
    {
        $length = $this->definition->month($month)['length'];

        foreach ($this->definition->leapRules as $rule) {
            if ($rule->month === $month && $rule->appliesTo($year)) {
                $length += $rule->amount;
            }
        }

        return $length;
    }

    public function daysInYear(int $year, bool $includeIntercalary = true): int
    {
        $days = 0;
        foreach ($this->definition->months as $month) {
            if (! $includeIntercalary && ($month['type'] ?? 'standard') === 'intercalary') {
                continue;
            }
            $days += $month['length'];
        }

        foreach ($this->definition->leapRules as $rule) {
            if ($rule->appliesTo($year)
                && ($includeIntercalary || ! $this->definition->isIntercalary($rule->month))) {
                $days += $rule->amount;
            }
        }

        return $days;
    }

    /**
     * Return the zero-based ordinal of a date relative to year 0, day 1.
     * Calendars without year zero use year 1, day 1 as ordinal zero.
     */
    public function toOrdinal(CalendarDate $date, bool $includeIntercalary = true): int
    {
        if (! $this->isValid($date)) {
            throw new InvalidArgumentException("Invalid date for calendar: {$date}");
        }

        $ordinal = $this->daysBeforeYear($date->year, $includeIntercalary);
        foreach ($this->definition->months as $index => $month) {
            $monthNumber = $index + 1;
            if ($monthNumber >= $date->month) {
                break;
            }
            if ($includeIntercalary || ($month['type'] ?? 'standard') !== 'intercalary') {
                $ordinal += $month['length'];
            }
        }

        foreach ($this->definition->leapRules as $rule) {
            if ($rule->appliesTo($date->year)
                && $rule->month < $date->month
                && ($includeIntercalary || ! $this->definition->isIntercalary($rule->month))) {
                $ordinal += $rule->amount;
            }
        }

        return $ordinal + $date->day - 1;
    }

    public function fromOrdinal(int $ordinal, bool $includeIntercalary = true): CalendarDate
    {
        $serial = $this->yearSerialForOrdinal($ordinal, $includeIntercalary);
        $year = $this->yearFromSerial($serial);
        $dayOfYear = $ordinal - $this->daysBeforeSerial($serial, $includeIntercalary);

        foreach ($this->definition->months as $index => $month) {
            $monthNumber = $index + 1;
            if (! $includeIntercalary && ($month['type'] ?? 'standard') === 'intercalary') {
                continue;
            }

            $length = $this->daysInMonth($year, $monthNumber);
            if (! $includeIntercalary && $this->definition->isIntercalary($monthNumber)) {
                $length = 0;
            }
            if ($dayOfYear < $length) {
                return new CalendarDate($year, $monthNumber, $dayOfYear + 1);
            }
            $dayOfYear -= $length;
        }

        throw new InvalidArgumentException("Unable to convert ordinal {$ordinal} to a calendar date.");
    }

    public function addDays(CalendarDate $date, int $days): CalendarDate
    {
        return $this->fromOrdinal($this->toOrdinal($date) + $days);
    }

    public function addMonths(CalendarDate $date, int $months, string $invalidDate = 'skip'): ?CalendarDate
    {
        $serial = $this->monthSerial($date->year, $date->month) + $months;
        $yearSerial = self::floorDiv($serial, $this->definition->monthCount());
        $month = $serial - ($yearSerial * $this->definition->monthCount()) + 1;
        $year = $this->yearFromSerial($yearSerial);
        $day = $date->day;
        $length = $this->daysInMonth($year, $month);

        if ($day > $length) {
            if ($invalidDate === 'skip') {
                return null;
            }
            if ($invalidDate !== 'clamp') {
                throw new InvalidArgumentException("Unknown invalid-date policy: {$invalidDate}");
            }
            $day = $length;
        }

        return new CalendarDate($year, $month, $day);
    }

    public function addYears(CalendarDate $date, int $years, string $invalidDate = 'skip'): ?CalendarDate
    {
        $year = $this->yearFromSerial($this->yearSerial($date->year) + $years);
        $day = $date->day;
        $length = $this->daysInMonth($year, $date->month);

        if ($day > $length) {
            if ($invalidDate === 'skip') {
                return null;
            }
            if ($invalidDate !== 'clamp') {
                throw new InvalidArgumentException("Unknown invalid-date policy: {$invalidDate}");
            }
            $day = $length;
        }

        return new CalendarDate($year, $date->month, $day);
    }

    public function weekdayIndex(CalendarDate $date): int
    {
        $weekdays = $this->definition->weekdayCount();
        $weekday = ($this->toOrdinal($date) + $this->definition->startOffset) % $weekdays;

        return $weekday < 0 ? $weekday + $weekdays : $weekday;
    }

    public function dayOfYear(CalendarDate $date): int
    {
        return $this->toOrdinal($date) - $this->daysBeforeYear($date->year, true) + 1;
    }

    private function daysBeforeYear(int $year, bool $includeIntercalary): int
    {
        return $this->daysBeforeSerial($this->yearSerial($year), $includeIntercalary);
    }

    private function daysBeforeSerial(int $serial, bool $includeIntercalary): int
    {
        $base = $this->baseDaysInYear($includeIntercalary);
        $days = $base * $serial;

        foreach ($this->definition->leapRules as $rule) {
            if (! $includeIntercalary && $this->definition->isIntercalary($rule->month)) {
                continue;
            }
            $days += $rule->amount * $this->leapYearsBeforeSerial($rule, $serial);
        }

        return $days;
    }

    private function baseDaysInYear(bool $includeIntercalary): int
    {
        $days = 0;
        foreach ($this->definition->months as $month) {
            if ($includeIntercalary || ($month['type'] ?? 'standard') !== 'intercalary') {
                $days += $month['length'];
            }
        }

        return $days;
    }

    private function leapYearsBeforeSerial(LeapRule $rule, int $serial): int
    {
        if ($serial === 0) {
            return 0;
        }

        if ($this->definition->hasYearZero) {
            return $serial > 0
                ? $this->countRule($rule, 0, $serial - 1)
                : -$this->countRule($rule, $serial, -1);
        }

        return $serial > 0
            ? $this->countRule($rule, 1, $serial)
            : -$this->countRule($rule, $serial, -1);
    }

    private function countRule(LeapRule $rule, int $from, int $to): int
    {
        if ($from > $to || $to < $rule->startYear) {
            return 0;
        }
        $from = max($from, $rule->startYear);
        if ($from > $to) {
            return 0;
        }

        $first = $rule->startYear + self::ceilDiv($from - $rule->startYear, $rule->interval) * $rule->interval;

        return $first > $to ? 0 : intdiv($to - $first, $rule->interval) + 1;
    }

    private function yearSerial(int $year): int
    {
        if ($this->definition->hasYearZero) {
            return $year;
        }

        if ($year === 0) {
            throw new InvalidArgumentException('This calendar does not have a year zero.');
        }

        return $year > 0 ? $year - 1 : $year;
    }

    private function yearFromSerial(int $serial): int
    {
        if ($this->definition->hasYearZero || $serial < 0) {
            return $serial;
        }

        return $serial + 1;
    }

    private function monthSerial(int $year, int $month): int
    {
        return $this->yearSerial($year) * $this->definition->monthCount() + $month - 1;
    }

    private function yearSerialForOrdinal(int $ordinal, bool $includeIntercalary): int
    {
        $base = max(1, $this->baseDaysInYear($includeIntercalary));
        $estimate = self::floorDiv($ordinal, $base);
        $low = $estimate;
        $high = $estimate;
        $step = 1;

        while ($this->daysBeforeSerial($low, $includeIntercalary) > $ordinal) {
            $low -= $step;
            $step *= 2;
        }
        $step = 1;
        while ($this->daysBeforeSerial($high + 1, $includeIntercalary) <= $ordinal) {
            $high += $step;
            $step *= 2;
        }

        while ($low < $high) {
            $middle = $low + intdiv($high - $low + 1, 2);
            if ($this->daysBeforeSerial($middle, $includeIntercalary) <= $ordinal) {
                $low = $middle;
            } else {
                $high = $middle - 1;
            }
        }

        return $low;
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
