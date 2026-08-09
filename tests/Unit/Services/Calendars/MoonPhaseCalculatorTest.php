<?php

use App\Services\Calendars\CalendarChronology;
use App\Services\Calendars\MoonPhaseCalculator;
use App\ValueObjects\Calendars\CalendarDate;
use App\ValueObjects\Calendars\CalendarDefinition;

function moonCalculator(array $moons = []): MoonPhaseCalculator
{
    return new MoonPhaseCalculator(new CalendarChronology(CalendarDefinition::fromArray([
        'months' => [
            ['name' => 'First', 'length' => 30],
            ['name' => 'Second', 'length' => 30],
        ],
        'weekdays' => ['One', 'Two', 'Three', 'Four', 'Five'],
        'moons' => $moons ?: [
            ['id' => 1, 'name' => 'Luna', 'fullmoon' => 16, 'offset' => 0, 'colour' => 'grey'],
        ],
    ])));
}

it('returns the latest phase and its age for every date', function () {
    $calculator = moonCalculator();

    $state = $calculator->statesAt(new CalendarDate(0, 1, 3))[0];
    expect($state->phase)->toBe('waning_gibbous')
        ->and($state->daysSincePhase)->toBe(0)
        ->and($state->phaseDate)->toEqual(new CalendarDate(0, 1, 3));

    $exact = $calculator->statesAt(new CalendarDate(0, 1, 5))[0];
    expect($exact->phase)->toBe('last_quarter')
        ->and($exact->isExact())->toBeTrue();
});

it('calculates all eight phases in lunar order', function () {
    $phases = moonCalculator()->phasesBetween(
        new CalendarDate(0, 1, 1),
        new CalendarDate(0, 1, 16),
    );

    expect(array_map(static fn ($phase): string => $phase->phase, $phases))
        ->toBe([
            'full',
            'waning_gibbous',
            'last_quarter',
            'waning_crescent',
            'new',
            'waxing_crescent',
            'first_quarter',
            'waxing_gibbous',
        ])
        ->and(array_map(static fn ($phase): string => $phase->date->key(), $phases))
        ->toBe(['0-1-1', '0-1-3', '0-1-5', '0-1-7', '0-1-9', '0-1-11', '0-1-13', '0-1-15']);
});

it('applies offsets to absolute phase ordinals', function () {
    $calculator = moonCalculator([
        ['id' => 1, 'name' => 'Luna', 'fullmoon' => 10, 'offset' => 2],
    ]);

    $phases = $calculator->phasesBetween(new CalendarDate(0, 1, 2), new CalendarDate(0, 1, 3));

    expect($phases)->toHaveCount(1)
        ->and($phases[0]->phase)->toBe('full')
        ->and($phases[0]->date)->toEqual(new CalendarDate(0, 1, 3));
});

it('uses mathematical flooring for fractional and negative phase boundaries', function () {
    $calculator = moonCalculator([
        ['id' => 1, 'name' => 'Luna', 'fullmoon' => '2.5', 'offset' => 0],
    ]);

    $phases = $calculator->phasesBetween(new CalendarDate(-1, 2, 28), new CalendarDate(0, 1, 2));
    $fullMoons = array_values(array_filter($phases, static fn ($phase): bool => $phase->phase === 'full'));

    expect($fullMoons[0]->date)->toEqual(new CalendarDate(-1, 2, 28))
        ->and($fullMoons[1]->date)->toEqual(new CalendarDate(0, 1, 1));
});

it('keeps multiple moons independent', function () {
    $calculator = moonCalculator([
        ['id' => 1, 'name' => 'Luna', 'fullmoon' => 16, 'offset' => 0],
        ['id' => 2, 'name' => 'Selene', 'fullmoon' => 20, 'offset' => 4],
    ]);

    $states = $calculator->statesAt(new CalendarDate(0, 1, 1));

    expect($states)->toHaveCount(2)
        ->and($states[0]->moonId)->toBe(1)
        ->and($states[1]->moonId)->toBe(2);
});
