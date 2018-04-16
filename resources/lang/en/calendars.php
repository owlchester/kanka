<?php

return [
    'actions' => [
        'add_month' => 'Add a month',
        'add_weekday' => 'Add a week day',
        'add_year' => 'Add a year name',
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
    'fields'        => [
        'name'      => 'Name',
        'type'      => 'Type',
        'suffix' => 'Suffix',
        'months' => 'Months',
        'weekdays' => 'Week Days',
        'seasons' => 'Seasons',
        'date' => 'Current Date',
        'parameters' => 'Parameters',
        'current_year' => 'Current Year',
        'current_month' => 'Current Month',
        'current_day' => 'Current Day',
        'leap_year_amount' => 'Add Days',
        'leap_year_month' => 'Month',
        'leap_year_offset' => 'Every',
        'leap_year_start' => 'Leap Year',
        'has_leap_year' => 'Has leap years',
    ],
    'index'         => [
        'add'           => 'New Calendar',
        'description'   => 'Manage the calendars of :name.',
        'header'        => 'Calendars of :name',
        'title'         => 'Calendars',
    ],
    'panels' => [
        'leap_year' => 'Leap Year',
        'years' => 'Named Years',
    ],
    'placeholders'  => [
        'name'      => 'Name of the calendar',
        'type'      => 'Type of the calendar',
        'suffix' => 'Current Era suffix (AC, BC)',
        'months' => 'Number of months in a year',
        'weekdays' => 'Number of days in a week',
        'seasons' => 'Number of seasons',
        'date' => 'The current date',
        'leap_year_amount' => 'Number of days added on a leap year',
        'leap_year_month' => 'Month on which days are added',
        'leap_year_offset' => 'Every how many years is a leap year',
        'leap_year_start' => 'First year that is a leap year',
    ],
    'show'          => [
        'description'   => 'A detailed view of an calendar',
        'tabs'          => [
            'information'   => 'Information',
        ],
        'title'         => 'Calendar :name',
    ],
    'parameters' => [
        'month' => [
            'name' => 'Month Name',
            'length' => 'Number of days',
        ],
        'year' => [
            'number' => 'Year',
            'name' => 'Name',
        ]
    ]
];
