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
    'helpers'       => [
        'descendants'   => 'This list contains all locations which are descendants of this locations, not only those directly under it.',
        'nested'        => 'When in Nested View, you can view your locations in a nested manner. Locations with no parent location will be shown by default. Locations with children locations can be clicked to view those children. You can keep clicking until there are no more children to view.',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Nested View',
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
            'admin_mode'    => 'Enable Edit Mode',
            'view_mode'     => 'Back to View Mode',
            'big'           => 'Full View',
            'download'      => 'Download',
            'points'        => 'Edit Points',
            'toggle_hide'   => 'Hide Points',
            'toggle_show'   => 'Show Points',
            'zoom_in'       => 'Zoom In',
            'zoom_out'      => 'Zoom Out',
            'zoom_reset'    => 'Zoom Reset',
        ],
        'helper'    => 'Click on the map to add a new point to a location, or click on an existing point to change or delete it.',
        'helpers' => [
            'admin' => 'Use the :button button on the top-right of the map to enable clicking anywhere on the map to add new points, clicking on points to edit them, or moving them around.',
            'view' => 'Click on any map point to view details about it.',
            'label' => 'This point is a label. Nothing more, nothing less.'
        ],
        'modal'     => [
            'submit'    => 'Add',
            'title'     => 'Target of new point',
        ],
        'no_map'    => 'You can upload a map to this location when editing it. Once a map has been provided, it will appear here.',
        'points'    => [
            'fields'        => [
                'axis_x'    => 'X Axis',
                'axis_y'    => 'Y Axis',
                'colour'    => 'Colour',
                'name'      => 'Label',
                'shape'     => 'Shape',
                'size'      => 'Size',
                'icon'      => 'Icon',
            ],
            'helpers'       => [
                'location_or_name'  => 'A map point can either point to an existing location, or just have a label.',
            ],
            'icons'         => [
                'pin' => 'Pin',
                'entity' => 'Target Entity Image',
                'skull' => 'Skull',
                'book' => 'Book',
                'aura' => 'Aura',
                'tower' => 'Tower',
                'fire' => 'Fire',
                'beer' => 'Beer',
                'dragon' => 'Dragon',
                'tentacle' => 'Tentacle',
                'spades-card' => 'Spades Card',
                'anvil' => 'Anvil',
                'axe' => 'Axe',
                'shield' => 'Shield',
                'bridge' => 'Bridge',
                'campfire' => 'Campfire',
                'quest' => 'Wooden Sign',
                'character' => 'Character',
                'sprout' => 'Sprout',
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
            'shapes' => [
                'circle' => 'Circle',
                'square' => 'Square',
            ],
            'sizes' => [
                'small' => 'Small',
                'standard' => 'Standard',
                'large' => 'Large',
            ],
            'title'         => 'Location :name Map Points',
        ],
        'success'   => 'Map Points saved.',
    ],
    'organisations' => [
        'description'   => 'Organisations situated in the location.',
        'title'         => 'Location :name Organisations',
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
            'organisations' => 'Organisations',
        ],
        'title'         => 'Location :name',
    ],
];
