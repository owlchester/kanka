<?php

return [
    'index' => [
        'title' => 'Locations',
        'description' => 'Manage the location of your campaign.',
        'add' => 'New Location',
        'header' => 'Locations in :name'
    ],
    'create' => [
        'title' => 'Create a new location',
        'description' => '',
        'success' => 'Location created.',
    ],
    'show' => [
        'title' => 'Location :location',
        'description' => 'A detailed view of a location',
        'tabs' => [
            'information' => 'Information',
            'characters' => 'Characters',
            'locations' => 'Locations',
        ],
    ],
    'edit' => [
        'title' => 'Edit Location :location',
        'description' => '',
        'success' => 'Location updated.',
    ],
    'destroy' => [
        'success' => 'Location removed.',
    ],
    'fields' => [
        'name' => 'Name',
        'type' => 'Type',
        'location' => 'Location',
        'characters' => 'Characters',
        'description' => 'Description',
        'history' => 'History',
        'image' => 'Image',
    ],
    'placeholders' => [
        'name' => 'Name of the location',
        'type' => 'City, Kingdom, Ruin',
        'location' => 'Choose a parent location',
    ]
];
