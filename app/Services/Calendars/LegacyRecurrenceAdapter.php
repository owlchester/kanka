<?php

namespace App\Services\Calendars;

use App\Models\Reminder;
use App\ValueObjects\Calendars\RecurrenceRule;
use InvalidArgumentException;

final class LegacyRecurrenceAdapter
{
    public function fromReminder(Reminder $reminder): ?RecurrenceRule
    {
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
        if (! preg_match('/^(\d+)_(f|n)$/', $periodicity, $parts)) {
            throw new InvalidArgumentException("Unsupported legacy recurrence: {$periodicity}");
        }

        return new RecurrenceRule(
            RecurrenceRule::MOON_PHASE,
            untilYear: $untilYear,
            moonId: (int) $parts[1],
            phase: $parts[2] === 'f' ? 'full' : 'new',
        );
    }
}
