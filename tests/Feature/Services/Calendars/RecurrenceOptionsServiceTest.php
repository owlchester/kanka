<?php

use App\Models\Calendar;
use App\Services\Calendars\RecurrenceOptionsService;

it('builds grouped select options from calendar moon definitions', function () {
    $calendar = new Calendar([
        'moons' => json_encode([
            ['id' => 1, 'name' => 'Luna'],
            ['id' => 2, 'name' => ''],
        ]),
    ]);

    $options = new RecurrenceOptionsService()->forSelect($calendar);

    expect($options['month'])->toBe(__('calendars.options.events.recurring_periodicity.month'))
        ->and($options['Luna'])->toHaveKeys([
            '1_f',
            '1_waning_gibbous',
            '1_last_quarter',
            '1_waning_crescent',
            '1_n',
            '1_waxing_crescent',
            '1_first_quarter',
            '1_waxing_gibbous',
        ])
        ->and($options['Luna']['1_waning_gibbous'])->toBe(__('calendars.options.events.recurring_periodicity.waning_gibbous'))
        ->and($options[__('calendars.options.events.recurring_periodicity.unnamed_moon', ['number' => 1])])->toHaveKeys([
            '2_f',
            '2_waning_gibbous',
            '2_last_quarter',
            '2_waning_crescent',
            '2_n',
            '2_waxing_crescent',
            '2_first_quarter',
            '2_waxing_gibbous',
        ]);
});

it('builds flat API options without grouping moon names', function () {
    $calendar = new Calendar([
        'moons' => json_encode([
            ['id' => 1, 'name' => 'Luna'],
        ]),
    ]);

    $options = new RecurrenceOptionsService()->forApi($calendar);

    expect($options)->toHaveKeys(['', 'month', 'year', '1_f', '1_n', '1_waning_gibbous', '1_last_quarter', '1_waning_crescent', '1_waxing_crescent', '1_first_quarter', '1_waxing_gibbous'])
        ->and($options['1_f'])->toBe(__('calendars.options.events.recurring_periodicity.fullmoon_name', ['moon' => 'Luna']));
});
