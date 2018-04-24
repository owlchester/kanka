<?php

return [
    'create'        => [
        'description'   => 'Create a new location',
        'success'       => 'Location \':name\' created.',
        'title'         => 'New Location',
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
        'image'         => 'Image',
        'location'      => 'Location',
        'locations'     => 'Locations',
        'map'           => 'Map',
        'name'          => 'Name',
        'relation'      => 'Relation',
        'type'          => 'Type',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Exploration View',
        ],
        'add'           => 'New Location',
        'description'   => 'Manage the location of :name.',
        'header'        => 'Locations in :name',
        'title'         => 'Locations',
    ],
    'map'           => [
        'actions'   => [
            'points'    => 'Edit Points',
        ],
        'helper'    => 'Click on the map to add a link to a location, or click on an existing point to remove it.',
        'modal'     => [
            'submit'    => 'Add',
            'title'     => 'Target of new point',
        ],
        'no_map'    => 'Please upload a map to the location first.',
        'points'    => [
            'title' => 'Location :name Map Points',
        ],
        'success'   => 'Map Points saved.',
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
            'map'           => 'Map',
        ],
        'title'         => 'Location :name',
    ],
];
