<?php

return [
    'create'        => [
        'description'   => '',
        'success'       => 'Location \':name\' created.',
        'title'         => 'Create a new location',
    ],
    'destroy'       => [
        'success'   => 'Location \':name\' removed.',
    ],
    'edit'          => [
        'description'   => '',
        'success'       => 'Location \':name\' updated.',
        'title'         => 'Edit Location :name',
    ],
    'fields'        => [
        'characters'    => 'Characters',
        'map' => 'Map',
        'location'      => 'Location',
        'name'          => 'Name',
        'relation'      => 'Relation',
        'type'          => 'Type',
        'locations' => 'Locations',
    ],
    'index'         => [
        'add'           => 'New Location',
        'description'   => 'Manage the location of :name.',
        'header'        => 'Locations in :name',
        'title'         => 'Locations',
        'actions' => [
            'explore_view' => 'Exploration View',
        ],
    ],
    'placeholders'  => [
        'location'  => 'Choose a parent location',
        'name'      => 'Name of the location',
        'type'      => 'City, Kingdom, Ruin',
    ],
    'show'          => [
        'description'   => 'A detailed view of a location',
        'tabs'          => [
            'characters'    => 'Characters',
            'information'   => 'Information',
            'locations'     => 'Locations',
            'map' => 'Map',
        ],
        'title'         => 'Location :name',
    ],
    'map' => [
        'helper' => 'Click on the map to add a link to a location, or click on an existing point to remove it.',
        'no_map' => 'Please upload a map to the location first.',
        'actions' => [
            'points' => 'Edit Points',
        ],
        'points' => [
            'title' => 'Location :name Map Points'
        ],
        'success' => 'Map Points saved.',
        'modal' => [
            'title' => 'Target of new point',
            'submit' => 'Add',
        ]
    ]
];
