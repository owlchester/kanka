<?php

use App\Services\Calendars\CalendarChronology;
use App\ValueObjects\Calendars\CalendarDate;
use App\ValueObjects\Calendars\CalendarDefinition;

function chronology(array $overrides = []): CalendarChronology
{
    return new CalendarChronology(CalendarDefinition::fromArray(array_merge([
        'months' => [
            ['name' => 'First', 'length' => 30],
            ['name' => 'Second', 'length' => 30],
        ],
        'weekdays' => ['One', 'Two', 'Three', 'Four', 'Five'],
    ], $overrides)));
}

it('round trips dates through a continuous ordinal timeline', function () {
    $chronology = chronology();

    foreach ([
        new CalendarDate(-2, 2, 30),
        new CalendarDate(-1, 1, 1),
        new CalendarDate(0, 1, 1),
        new CalendarDate(1, 2, 30),
        new CalendarDate(3, 1, 1),
    ] as $date) {
        expect($chronology->fromOrdinal($chronology->toOrdinal($date)))->toEqual($date);
    }
});

it('skips year zero when configured to do so', function () {
    $chronology = chronology(['skip_year_zero' => true]);

    expect($chronology->addDays(new CalendarDate(-1, 2, 30), 1))
        ->toEqual(new CalendarDate(1, 1, 1));
    expect($chronology->addDays(new CalendarDate(1, 1, 1), -1))
        ->toEqual(new CalendarDate(-1, 2, 30));
});

it('applies multiple leap rules to month lengths and year lengths', function () {
    $chronology = chronology([
        'leap_rules' => [
            ['amount' => 1, 'month' => 1, 'interval' => 2, 'start' => 1],
            ['amount' => 2, 'month' => 2, 'interval' => 3, 'start' => 1],
        ],
    ]);

    expect($chronology->isLeapYear(1))->toBeTrue()
        ->and($chronology->daysInMonth(1, 1))->toBe(31)
        ->and($chronology->daysInMonth(1, 2))->toBe(32)
        ->and($chronology->daysInYear(1))->toBe(63);
});

it('moves through leap days instead of skipping them', function () {
    $chronology = new CalendarChronology(CalendarDefinition::fromArray([
        'months' => [
            ['name' => 'First', 'length' => 31],
            ['name' => 'Second', 'length' => 28],
            ['name' => 'Third', 'length' => 31],
        ],
        'leap_rules' => [
            ['amount' => 1, 'month' => 2, 'interval' => 4, 'start' => 4],
        ],
    ]));

    expect($chronology->addDays(new CalendarDate(4, 2, 28), 1))
        ->toEqual(new CalendarDate(4, 2, 29))
        ->and($chronology->addDays(new CalendarDate(4, 2, 29), 1))
        ->toEqual(new CalendarDate(4, 3, 1));
});

it('uses an explicit policy for invalid monthly dates', function () {
    $chronology = chronology([
        'months' => [
            ['name' => 'Short', 'length' => 28],
            ['name' => 'Long', 'length' => 31],
        ],
    ]);
    $anchor = new CalendarDate(1, 2, 31);

    expect($chronology->addMonths($anchor, 1))->toBeNull()
        ->and($chronology->addMonths($anchor, 1, 'clamp'))->toEqual(new CalendarDate(2, 1, 28));
});

it('calculates weekdays from the same ordinal used for date arithmetic', function () {
    $chronology = chronology(['start_offset' => 2]);

    expect($chronology->weekdayIndex(new CalendarDate(0, 1, 1)))->toBe(2)
        ->and($chronology->weekdayIndex(new CalendarDate(0, 2, 1)))->toBe(2);
});
