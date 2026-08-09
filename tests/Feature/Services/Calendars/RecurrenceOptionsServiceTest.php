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
        ->and($options['Luna'])->toBe([
            '1_f' => __('calendars.options.events.recurring_periodicity.fullmoon'),
            '1_n' => __('calendars.options.events.recurring_periodicity.newmoon'),
        ])
        ->and($options[__('calendars.options.events.recurring_periodicity.unnamed_moon', ['number' => 1])])->toBe([
            '2_f' => __('calendars.options.events.recurring_periodicity.fullmoon'),
            '2_n' => __('calendars.options.events.recurring_periodicity.newmoon'),
        ]);
});

it('builds flat API options without grouping moon names', function () {
    $calendar = new Calendar([
        'moons' => json_encode([
            ['id' => 1, 'name' => 'Luna'],
        ]),
    ]);

    $options = new RecurrenceOptionsService()->forApi($calendar);

    expect($options)->toHaveKeys(['', 'month', 'year', '1_f', '1_n'])
        ->and($options['1_f'])->toBe(__('calendars.options.events.recurring_periodicity.fullmoon_name', ['moon' => 'Luna']));
});
