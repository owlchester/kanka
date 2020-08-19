<?php

return [
    'create'        => [
        'description'   => 'Create a new event',
        'success'       => 'Event \':name\' created.',
        'title'         => 'New Event',
    ],
    'destroy'       => [
        'success'   => 'Event \':name\' removed.',
    ],
    'edit'          => [
        'success'   => 'Event \':name\' updated.',
        'title'     => 'Edit Event :name',
    ],
    'fields'        => [
        'date'      => 'Date',
        'image'     => 'Image',
        'location'  => 'Location',
        'name'      => 'Name',
        'type'      => 'Type',
    ],
    'helpers'       => [
        'date'  => 'This field can contain anything and is not linked to the campaign\'s calendars. To link this event to a calendar, go add it on the calendar or on the reminders tab of this event.',
    ],
    'index'         => [
        'add'           => 'New Event',
        'description'   => 'Manage the events of :name.',
        'header'        => 'Events of :name',
        'title'         => 'Events',
    ],
    'placeholders'  => [
        'date'      => 'A date for your event',
        'location'  => 'Choose a location',
        'name'      => 'Name of the event',
        'type'      => 'Ceremony, Festival, Disaster, Battle, Birth',
    ],
    'show'          => [
        'description'   => 'A detailed view of an event',
        'tabs'          => [
            'information'   => 'Information',
        ],
        'title'         => 'Event :name',
    ],
    'tabs'          => [
        'calendars' => 'Calendar Entries',
    ],
];
