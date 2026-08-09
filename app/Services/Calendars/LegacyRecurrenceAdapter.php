<?php

namespace App\Services\Calendars;

use App\Models\Reminder;
use App\ValueObjects\Calendars\RecurrenceRule;
use InvalidArgumentException;

final class LegacyRecurrenceAdapter
{
    public function fromReminder(Reminder $reminder): ?RecurrenceRule
    {
        if (! (bool) $reminder->is_recurring) {
            return null;
        }

        $periodicity = (string) ($reminder->recurring_periodicity ?? '');
        if ($periodicity === '') {
            return null;
        }

        $untilYear = $reminder->recurring_until;
        if ($untilYear !== null && $untilYear !== '' && ! is_numeric($untilYear)) {
            throw new InvalidArgumentException("Invalid recurrence end year: {$untilYear}");
        }
        $untilYear = $untilYear === null || $untilYear === '' ? null : (int) $untilYear;

        return match ($periodicity) {
            'month' => new RecurrenceRule(RecurrenceRule::MONTHLY, untilYear: $untilYear),
            'year' => new RecurrenceRule(RecurrenceRule::YEARLY, untilYear: $untilYear),
            default => $this->moonRule($periodicity, $untilYear),
        };
    }

    private function moonRule(string $periodicity, ?int $untilYear): RecurrenceRule
    {
        $suffixes = implode('|', array_map(
            MoonPhase::recurrenceSuffix(...),
            array_keys(MoonPhase::PHASES),
        ));
        if (! preg_match('/^(\d+)_(' . $suffixes . ')$/', $periodicity, $parts)) {
            throw new InvalidArgumentException("Unsupported legacy recurrence: {$periodicity}");
        }

        return new RecurrenceRule(
            RecurrenceRule::MOON_PHASE,
            untilYear: $untilYear,
            moonId: (int) $parts[1],
            phase: MoonPhase::fromRecurrenceSuffix($parts[2]),
        );
    }
}
