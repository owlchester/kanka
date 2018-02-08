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
        'description'   => 'Description',
        'history'       => 'History',
        'image'         => 'Image',
        'location'      => 'Location',
        'name'          => 'Name',
        'relation'      => 'Relation',
        'type'          => 'Type',
    ],
    'index'         => [
        'add'           => 'New Location',
        'description'   => 'Manage the location of :name.',
        'header'        => 'Locations in :name',
        'title'         => 'Locations',
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
        ],
        'title'         => 'Location :name',
    ],
];
