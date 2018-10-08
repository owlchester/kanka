<?php

return [
    'characters'    => [
        'description'   => 'Characters located at the location.',
        'title'         => 'Location :name Characters',
    ],
    'create'        => [
        'description'   => 'Create a new location',
        'success'       => 'Location \':name\' created.',
        'title'         => 'New Location',
    ],
    'destroy'       => [
        'success'   => 'Location \':name\' removed.',
    ],
    'edit'          => [
        'success'   => 'Location \':name\' updated.',
        'title'     => 'Edit Location :name',
    ],
    'events'        => [
        'description'   => 'Events which took place at the location.',
        'title'         => 'Location :name Events',
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
    'items'         => [
        'description'   => 'Items located in or from the location.',
        'title'         => 'Location :name Items',
    ],
    'locations'     => [
        'description'   => 'Locations located in the location.',
        'title'         => 'Location :name Locations',
    ],
    'map'           => [
        'actions'   => [
            'big'           => 'Full View',
            'download'      => 'Download',
            'points'        => 'Edit Points',
            'toggle_hide'   => 'Hide Points',
            'toggle_show'   => 'Show Points',
            'zoom_in'       => 'Zoom In',
            'zoom_out'      => 'Zoom Out',
        ],
        'helper'    => 'Click on the map to add a new point to a location, or click on an existing point to change or delete it.',
        'modal'     => [
            'submit'    => 'Add',
            'title'     => 'Target of new point',
        ],
        'no_map'    => 'Please upload a map to the location first.',
        'points'    => [
            'fields'        => [
                'axis_x'    => 'X Axis',
                'axis_y'    => 'Y Axis',
                'colour'    => 'Colour',
                'name'      => 'Label',
            ],
            'helpers'       => [
                'location_or_name'  => 'A map point can either point to an existing location, or just have a label.',
            ],
            'placeholders'  => [
                'axis_x'    => 'Left position',
                'axis_y'    => 'Top position',
                'name'      => 'Label of the point when no location is provided.',
            ],
            'return'        => 'Back to :name',
            'success'       => [
                'create'    => 'Location Map Point created.',
                'delete'    => 'Location Map Point removed.',
                'update'    => 'Location Map Point updated.',
            ],
            'title'         => 'Location :name Map Points',
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
            'events'        => 'Events',
            'information'   => 'Information',
            'items'         => 'Items',
            'locations'     => 'Locations',
            'map'           => 'Map',
            'menu'          => 'Menu',
        ],
        'title'         => 'Location :name',
    ],
];
