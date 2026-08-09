<?php

namespace App\ValueObjects\Calendars;

use App\Models\Calendar;
use InvalidArgumentException;

final readonly class CalendarDefinition
{
    /** @param array<int, array{name: string, length: int, type?: string, alias?: string}> $months */
    /** @param array<int, string|array{name?: string}> $weekdays */
    /** @param array<int, LeapRule> $leapRules */
    /** @param array<int, array{id?: int, name?: string, fullmoon: float|int, offset?: float|int, colour?: string}> $moons */
    public function __construct(
        public array $months,
        public array $weekdays = [],
        public array $leapRules = [],
        public array $moons = [],
        public bool $hasYearZero = true,
        public int $startOffset = 0,
    ) {
        if ($this->months === []) {
            throw new InvalidArgumentException('A calendar must define at least one month.');
        }
    }

    public static function fromCalendar(Calendar $calendar): self
    {
        $rules = [];
        if ((bool) $calendar->has_leap_year) {
            $rules[] = new LeapRule(
                (int) $calendar->leap_year_amount,
                (int) $calendar->leap_year_month,
                max(1, (int) $calendar->leap_year_offset),
                (int) $calendar->leap_year_start,
            );
        }

        return new self(
            self::normalizeMonths($calendar->months()),
            $calendar->weekdays(),
            $rules,
            $calendar->moons(),
            $calendar->hasYearZero(),
            (int) $calendar->start_offset,
        );
    }

    /** @param array<string, mixed> $config */
    public static function fromArray(array $config): self
    {
        $rules = array_map(
            static fn (array $rule): LeapRule => new LeapRule(
                (int) ($rule['amount'] ?? 0),
                (int) ($rule['month'] ?? 1),
                (int) ($rule['interval'] ?? 1),
                (int) ($rule['start'] ?? 0),
            ),
            $config['leap_rules'] ?? [],
        );

        return new self(
            self::normalizeMonths($config['months'] ?? []),
            $config['weekdays'] ?? [],
            $rules,
            $config['moons'] ?? [],
            ! (bool) ($config['skip_year_zero'] ?? false),
            (int) ($config['start_offset'] ?? 0),
        );
    }

    public function monthCount(): int
    {
        return count($this->months);
    }

    /** @return array{name: string, length: int, type: string, alias: string} */
    public function month(int $month): array
    {
        if ($month < 1 || $month > $this->monthCount()) {
            throw new InvalidArgumentException("Unknown calendar month: {$month}");
        }

        return $this->months[$month - 1];
    }

    public function weekdayCount(): int
    {
        return max(1, count($this->weekdays));
    }

    public function isIntercalary(int $month): bool
    {
        return ($this->month($month)['type'] ?? 'standard') === 'intercalary';
    }

    private static function normalizeMonths(mixed $months): array
    {
        if (! is_array($months)) {
            throw new InvalidArgumentException('Calendar months must be an array.');
        }

        return array_values(array_map(
            static function (mixed $month): array {
                if (! is_array($month) || (int) ($month['length'] ?? 0) < 1) {
                    throw new InvalidArgumentException('Each calendar month must have a positive length.');
                }

                return [
                    'name' => (string) ($month['name'] ?? ''),
                    'length' => (int) $month['length'],
                    'type' => (string) ($month['type'] ?? 'standard'),
                    'alias' => (string) ($month['alias'] ?? ''),
                ];
            },
            $months,
        ));
    }
}
