<?php

return [
    'actions'       => [
        'add_month'     => 'Add a month',
        'add_weekday'   => 'Add a week day',
        'add_year'      => 'Add a year name',
    ],
    'create'        => [
        'description'   => 'Create a new calendar',
        'success'       => 'Calendar \':name\' created.',
        'title'         => 'New Calendar',
    ],
    'destroy'       => [
        'success'   => 'Calendar \':name\' removed.',
    ],
    'edit'          => [
        'description'   => '',
        'success'       => 'Calendar \':name\' updated.',
        'title'         => 'Edit Calendar :name',
    ],
    'event'         => [
        'destroy'   => 'Event removed from calendar \':name\'.',
        'helpers'   => [
            'add'   => 'Add an existing event to this calendar.',
            'new'   => 'Or create a new event by simply providing a name.',
        ],
        'modal'     => [
            'title' => 'Add an event to the calendar',
        ],
        'success'   => 'Event \':event\' added to the calendar.',
    ],
    'fields'        => [
        'current_day'       => 'Current Day',
        'current_month'     => 'Current Month',
        'current_year'      => 'Current Year',
        'date'              => 'Current Date',
        'has_leap_year'     => 'Has leap years',
        'leap_year_amount'  => 'Add Days',
        'leap_year_month'   => 'Month',
        'leap_year_offset'  => 'Every',
        'leap_year_start'   => 'Leap Year',
        'months'            => 'Months',
        'name'              => 'Name',
        'parameters'        => 'Parameters',
        'seasons'           => 'Seasons',
        'suffix'            => 'Suffix',
        'type'              => 'Type',
        'weekdays'          => 'Week Days',
        'comment'           => 'Comment',
        'is_recurring'      => 'Recurring'
    ],
    'hints'     => [
        'is_recurring' => 'An event can be set to recurring. It will reappear every year on the same date.',
    ],
    'index'         => [
        'add'           => 'New Calendar',
        'description'   => 'Manage the calendars of :name.',
        'header'        => 'Calendars of :name',
        'title'         => 'Calendars',
    ],
    'panels'        => [
        'leap_year' => 'Leap Year',
        'years'     => 'Named Years',
    ],
    'parameters'    => [
        'month' => [
            'length'    => 'Number of days',
            'name'      => 'Month Name',
        ],
        'year'  => [
            'name'      => 'Name',
            'number'    => 'Year',
        ],
    ],
    'placeholders'  => [
        'date'              => 'The current date',
        'leap_year_amount'  => 'Number of days added on a leap year',
        'leap_year_month'   => 'Month on which days are added',
        'leap_year_offset'  => 'Every how many years is a leap year',
        'leap_year_start'   => 'First year that is a leap year',
        'months'            => 'Number of months in a year',
        'name'              => 'Name of the calendar',
        'seasons'           => 'Number of seasons',
        'suffix'            => 'Current Era suffix (AC, BC)',
        'type'              => 'Type of the calendar',
        'weekdays'          => 'Number of days in a week',
        'comment'           => 'Birthday, festival, solstice',
    ],
    'show'          => [
        'description'   => 'A detailed view of an calendar',
        'tabs'          => [
            'information'   => 'Information',
        ],
        'title'         => 'Calendar :name',
    ],
];
