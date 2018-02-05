<?php

return [
    'index' => [
        'title' => 'Locations',
        'description' => 'Manage the location of :name.',
        'add' => 'New Location',
        'header' => 'Locations in :name'
    ],
    'create' => [
        'title' => 'Create a new location',
        'description' => '',
        'success' => 'Location \':name\' created.',
    ],
    'show' => [
        'title' => 'Location :name',
        'description' => 'A detailed view of a location',
        'tabs' => [
            'information' => 'Information',
            'characters' => 'Characters',
            'locations' => 'Locations',
        ],
    ],
    'edit' => [
        'title' => 'Edit Location :name',
        'description' => '',
        'success' => 'Location \':name\' updated.',
    ],
    'destroy' => [
        'success' => 'Location \':name\' removed.',
    ],
    'fields' => [
        'name' => 'Name',
        'type' => 'Type',
        'location' => 'Location',
        'characters' => 'Characters',
        'description' => 'Description',
        'history' => 'History',
        'image' => 'Image',
        'relation' => 'Relation',
    ],
    'placeholders' => [
        'name' => 'Name of the location',
        'type' => 'City, Kingdom, Ruin',
        'location' => 'Choose a parent location',
    ],
];
