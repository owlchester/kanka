<?php

return [
    'create'        => [
        'title' => 'New Event',
    ],
    'events'        => [
        'helper'    => 'Events that have this entry as their parent event are displayed here.',
    ],
    'fields'        => [
        'date'  => 'Date',
    ],
    'helpers'       => [
        'date'  => 'This field can contain anything and is not linked to your calendars. To link this event to a calendar, go add it on the calendar or on the reminders subpage of this event.',
    ],
    'lists'         => [
        'empty' => 'Add significant moments such as battles, coronations, or discoveries to your world\'s history.',
    ],
    'placeholders'  => [
        'date'  => 'A date for the event',
        'type'  => 'Ceremony, Festival, Disaster, Battle, Birth',
    ],
    'tabs'          => [
        'calendars' => 'Calendar Entries',
    ],
];
