<?php

use App\Models\Reminder;
use App\Services\Calendars\CalendarChronology;
use App\Services\Calendars\LegacyRecurrenceAdapter;
use App\Services\Calendars\OccurrenceEngine;
use App\ValueObjects\Calendars\CalendarDate;
use App\ValueObjects\Calendars\CalendarDefinition;
use App\ValueObjects\Calendars\RecurrenceRule;

function occurrenceEngine(): OccurrenceEngine
{
    return new OccurrenceEngine(new CalendarChronology(CalendarDefinition::fromArray([
        'months' => [
            ['name' => 'First', 'length' => 30],
            ['name' => 'Second', 'length' => 30],
        ],
        'weekdays' => ['One', 'Two', 'Three', 'Four', 'Five'],
        'moons' => [
            ['id' => 1, 'name' => 'Moon', 'fullmoon' => 10, 'offset' => 0],
        ],
    ])));
}

it('expands fortnightly recurrence using the calendar week length', function () {
    $engine = occurrenceEngine();
    $occurrences = $engine->occurrences(
        new CalendarDate(0, 1, 1),
        1,
        new RecurrenceRule(RecurrenceRule::WEEKLY, interval: 2),
        new CalendarDate(0, 1, 1),
        new CalendarDate(0, 2, 10),
    );

    expect(array_map(fn ($occurrence) => $occurrence->start->key(), $occurrences))
        ->toBe(['0-1-1', '0-1-11', '0-1-21', '0-2-1']);
});

it('expands monthly recurrence and includes an event ending in the window', function () {
    $engine = occurrenceEngine();
    $occurrences = $engine->occurrences(
        new CalendarDate(0, 1, 30),
        3,
        new RecurrenceRule(RecurrenceRule::MONTHLY),
        new CalendarDate(0, 2, 1),
        new CalendarDate(0, 2, 2),
    );

    expect($occurrences)->toHaveCount(1)
        ->and($occurrences[0]->start)->toEqual(new CalendarDate(0, 1, 30))
        ->and($occurrences[0]->end)->toEqual(new CalendarDate(0, 2, 2));
});

it('honours an inclusive recurring end year', function () {
    $engine = occurrenceEngine();
    $occurrences = $engine->occurrences(
        new CalendarDate(0, 1, 1),
        1,
        new RecurrenceRule(RecurrenceRule::YEARLY, untilYear: 1),
        new CalendarDate(0, 1, 1),
        new CalendarDate(2, 2, 1),
    );

    expect(array_map(fn ($occurrence) => $occurrence->start->year, $occurrences))
        ->toBe([0, 1]);
});

it('adapts legacy monthly, yearly, and moon recurrence values', function () {
    $adapter = new LegacyRecurrenceAdapter;

    $monthly = new Reminder(['recurring_periodicity' => 'month', 'recurring_until' => '4']);
    $yearly = new Reminder(['recurring_periodicity' => 'year']);
    $moon = new Reminder(['recurring_periodicity' => '2_f']);

    expect($adapter->fromReminder($monthly)->frequency)->toBe(RecurrenceRule::MONTHLY)
        ->and($adapter->fromReminder($monthly)->untilYear)->toBe(4)
        ->and($adapter->fromReminder($yearly)->frequency)->toBe(RecurrenceRule::YEARLY)
        ->and($adapter->fromReminder($moon)->moonId)->toBe(2)
        ->and($adapter->fromReminder($moon)->phase)->toBe('full');
});

it('rejects unsupported legacy recurrence values', function () {
    $adapter = new LegacyRecurrenceAdapter;
    $reminder = new Reminder(['recurring_periodicity' => 'fortnight']);

    expect(fn () => $adapter->fromReminder($reminder))
        ->toThrow(InvalidArgumentException::class);
});

it('rejects malformed legacy recurrence end years', function () {
    $adapter = new LegacyRecurrenceAdapter;
    $reminder = new Reminder([
        'recurring_periodicity' => 'year',
        'recurring_until' => 'later',
    ]);

    expect(fn () => $adapter->fromReminder($reminder))
        ->toThrow(InvalidArgumentException::class);
});
