<?php

return [
    'index' => [
        'title' => 'Events',
        'description' => 'Manage the events of :name.',
        'add' => 'New Event',
        'header' => 'Events of :name',
    ],
    'create' => [
        'title' => 'Create a new event',
        'description' => '',
        'success' => 'Event \':name\' created.',
    ],
    'show' => [
        'title' => 'Event :name',
        'description' => 'A detailed view of an event',
        'tabs' => [
            'information' => 'Information',
        ],
    ],
    'edit' => [
        'title' => 'Edit Event :name',
        'description' => '',
        'success' => 'Event \':name\' updated.',
    ],
    'destroy' => [
        'success' => 'Event \':name\' removed.',
    ],

    'fields' => [
        'name' => 'Name',
        'location' => 'Location',
        'type' => 'Type',
        'date' => 'Date',
        'history' => 'History',
        'image' => 'Image',
    ],
    'placeholders' => [
        'name' => 'Name of the event',
        'type' => 'Ceremony, Festival, Disaster, Battle, Birth',
        'date' => 'A date for your event',
        'location' => 'Choose a location',
    ],
];
