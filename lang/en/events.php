<?php

return [
    'create'        => [
        'title' => 'New Event',
    ],
    'events'        => [
        'helper'    => 'Events that have this entity as their parent event are displayed here.',
        'title'     => 'Event :name Events',
    ],
    'fields'        => [
        'date'      => 'Date',
        'event'     => 'Parent Event',
        'events'    => 'Events',
    ],
    'helpers'       => [
        'date'              => 'This field can contain anything and is not linked to the campaign\'s calendars. To link this event to a calendar, go add it on the calendar or on the reminders subpage of this event.',
        'nested_without'    => 'Displaying all events that don\'t have a parent event. Click on a row to see the children events.',
    ],
    'index'         => [
        'title' => 'Events',
    ],
    'placeholders'  => [
        'date'      => 'A date for your event',
        'name'      => 'Name of the event',
        'type'      => 'Ceremony, Festival, Disaster, Battle, Birth',
    ],
    'show'          => [
        'tabs'  => [
            'events'    => 'Events',
        ],
    ],
    'tabs'          => [
        'calendars' => 'Calendar Entries',
    ],
];
