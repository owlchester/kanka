<?php

namespace App\Services\Calendars;

use InvalidArgumentException;

final class MoonPhase
{
    /** @var array<string, int> */
    public const PHASES = [
        'full' => 0,
        'waning_gibbous' => 1,
        'last_quarter' => 2,
        'waning_crescent' => 3,
        'new' => 4,
        'waxing_crescent' => 5,
        'first_quarter' => 6,
        'waxing_gibbous' => 7,
    ];

    public static function recurrenceSuffix(string $phase): string
    {
        return match ($phase) {
            'full' => 'f',
            'new' => 'n',
            default => self::assertValid($phase),
        };
    }

    public static function fromRecurrenceSuffix(string $suffix): string
    {
        return match ($suffix) {
            'f' => 'full',
            'n' => 'new',
            default => self::assertValid($suffix),
        };
    }

    public static function displayKey(string $phase): string
    {
        return $phase === 'first_quarter' ? '1first_quarter' : $phase;
    }

    private static function assertValid(string $phase): string
    {
        if (! isset(self::PHASES[$phase])) {
            throw new InvalidArgumentException("Unsupported moon phase: {$phase}");
        }

        return $phase;
    }
}
