<?php

return [
    'actions'       => [
        'add_month'     => 'Add a month',
        'add_weekday'   => 'Add a week day',
        'add_year'      => 'Add a year name',
        'today'         => 'Today',
    ],
    'colours'       => [
        '' => 'Default',
        'black' => 'Black',
        'blue' => 'Blue',
        'green' => 'Green',
        'maroon' => 'Maroon',
        'navy' => 'Navy',
        'orange' => 'Orange',
        'purple' => 'Purple',
        'red' => 'Red',
        'teal' => 'Teal',
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
        'description'   => 'Update the calendar',
        'success'       => 'Calendar \':name\' updated.',
        'title'         => 'Edit Calendar :name',
    ],
    'event'         => [
        'actions'   => [
            'existing'  => 'Existing Entity',
            'new'       => 'New Event',
            'switch'    => 'Change choice',
        ],
        'create' => [
            'title' => 'Add a Calendar Event to :name',
            'description' => 'Create a calendar event',
            'success' => 'Calendar event created'
        ],
        'destroy'   => 'Event removed from calendar \':name\'.',
        'edit' => [
            'title' => 'Update Calendar Event for :name',
            'description' => 'Update a calendar event',
            'success' => 'Calendar event updated'
        ],
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
        'colour'            => 'Colour',
        'comment'           => 'Comment',
        'current_day'       => 'Current Day',
        'current_month'     => 'Current Month',
        'current_year'      => 'Current Year',
        'date'              => 'Current Date',
        'has_leap_year'     => 'Has leap years',
        'is_recurring'      => 'Recurring',
        'leap_year_amount'  => 'Add Days',
        'leap_year_month'   => 'Month',
        'leap_year_offset'  => 'Every',
        'leap_year_start'   => 'Leap Year',
        'length'            => 'Event Length',
        'length_days'       => ':count day|:count days',
        'months'            => 'Months',
        'name'              => 'Name',
        'parameters'        => 'Parameters',
        'recurring_until'   => 'Recurring Until Year',
        'seasons'           => 'Seasons',
        'suffix'            => 'Suffix',
        'type'              => 'Type',
        'weekdays'          => 'Week Days',
    ],
    'hints'         => [
        'is_recurring'  => 'An event can be set to recurring. It will reappear every year on the same date.',
    ],
    'index'         => [
        'add'           => 'New Calendar',
        'description'   => 'Manage the calendars of :name.',
        'header'        => 'Calendars of :name',
        'title'         => 'Calendars',
    ],
    'layouts'       => [
        'month' => 'Month',
        'year'  => 'Year',
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
        'colour'            => 'Colour',
        'comment'           => 'Birthday, festival, solstice',
        'date'              => 'The current date',
        'leap_year_amount'  => 'Number of days added on a leap year',
        'leap_year_month'   => 'Month on which days are added',
        'leap_year_offset'  => 'Every how many years is a leap year',
        'leap_year_start'   => 'First year that is a leap year',
        'length'            => 'Event length in days',
        'months'            => 'Number of months in a year',
        'name'              => 'Name of the calendar',
        'recurring_until'   => 'Last recurring year (leave empty for forever recurring)',
        'seasons'           => 'Number of seasons',
        'suffix'            => 'Current Era suffix (AC, BC)',
        'type'              => 'Type of the calendar',
        'weekdays'          => 'Number of days in a week',
    ],
    'show'          => [
        'description'   => 'A detailed view of an calendar',
        'tabs'          => [
            'information'   => 'Information',
        ],
        'title'         => 'Calendar :name',
    ],
];
