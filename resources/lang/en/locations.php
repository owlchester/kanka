<?php

return [
    'characters'    => [
        'title' => 'Location :name Characters',
    ],
    'create'        => [
        'success'   => 'Location \':name\' created.',
        'title'     => 'New Location',
    ],
    'destroy'       => [
        'success'   => 'Location \':name\' removed.',
    ],
    'edit'          => [
        'success'   => 'Location \':name\' updated.',
        'title'     => 'Edit Location :name',
    ],
    'events'        => [
        'title' => 'Location :name Events',
    ],
    'families'      => [
        'title' => 'Location :name Families',
    ],
    'fields'        => [
        'characters'        => 'Characters',
        'image'             => 'Image',
        'is_map_private'    => 'Private Map',
        'location'          => 'Parent Location',
        'locations'         => 'Locations',
        'map'               => 'Map',
        'name'              => 'Name',
        'type'              => 'Type',
    ],
    'helpers'       => [
        'characters'        => 'View all characters in this location and its children locations, or just those directly located here.',
        'descendants'       => 'This list contains all locations which are descendants of this location, not only those directly under it.',
        'families'          => 'Locations can be the seat of powerful families.',
        'map'               => 'Adding a map to a location will allow you to place "Points" on the map, linking to other Entities in the campaign.',
        'map_deprecated_2'  => 'Maps are now their own module! Old maps can still be updated but all new maps go into the new Maps module.',
        'nested_parent'     => 'Displaying the locations of :parent.',
        'nested_without'    => 'Displaying all locations that don\'t have a parent location. Click on a row to see the children locations.',
        'organisations'     => 'View all organisations in this location and its children locations, or just those directly located here.',
    ],
    'hints'         => [
        'is_map_private'    => 'A private map will only be visible to members of the campaign\'s "Admin" role.',
    ],
    'index'         => [
        'title' => 'Locations',
    ],
    'locations'     => [
        'title' => 'Location :name Locations',
    ],
    'map'           => [
        'actions'   => [
            'admin_mode'        => 'Enable Edit Mode',
            'big'               => 'Full View',
            'confirm_delete'    => 'Are you sure you want to delete this map point?',
            'download'          => 'Download',
            'points'            => 'Edit Points',
            'toggle_hide'       => 'Hide Points',
            'toggle_show'       => 'Show Points',
            'view_mode'         => 'Back to View Mode',
            'zoom_in'           => 'Zoom In',
            'zoom_out'          => 'Zoom Out',
            'zoom_reset'        => 'Zoom Reset',
        ],
        'helper'    => 'Click on the map to add a new point to a location, or click on an existing point to change or delete it.',
        'helpers'   => [
            'admin' => 'Activate to enable clicking anywhere on the map to add new points, clicking on points to edit them, or moving them around.',
            'info'  => 'More info about maps.',
            'label' => 'This point is a label. Nothing more, nothing less.',
            'view'  => 'Click on any map point to view details about it. Use Ctrl+Zoom to zoom in an out of the map.',
        ],
        'legend'    => 'Legend',
        'modal'     => [
            'submit'    => 'Add',
            'title'     => 'Target of new point',
        ],
        'no_map'    => 'This feature no longer exists, please use the Maps module to upload maps to your campaign.',
        'points'    => [
            'empty_label'   => 'Unnamed Point',
            'fields'        => [
                'axis_x'    => 'X Axis',
                'axis_y'    => 'Y Axis',
                'colour'    => 'Background colour',
                'icon'      => 'Icon',
                'name'      => 'Label',
                'shape'     => 'Shape',
                'size'      => 'Size',
            ],
            'helpers'       => [
                'location_or_name'  => 'A map point can either point to an existing Entity, or just have a label.',
            ],
            'icons'         => [
                'anchor'        => 'Anchor',
                'anvil'         => 'Anvil',
                'apple'         => 'Apple',
                'aura'          => 'Aura',
                'axe'           => 'Axe',
                'beer'          => 'Beer',
                'biohazard'     => 'Biohazard',
                'book'          => 'Book',
                'bridge'        => 'Bridge',
                'campfire'      => 'Campfire',
                'candle'        => 'Candle',
                'capitol'       => 'Capitol',
                'castle-emblem' => 'Castle',
                'cat'           => 'Cat',
                'cheese'        => 'Cheese',
                'cog'           => 'Cog',
                'crown'         => 'Crown',
                'dead-tree'     => 'Dead Tree',
                'diamond'       => 'Diamond',
                'dragon'        => 'Dragon',
                'emerald'       => 'Emerald',
                'entity'        => 'Target Entity Image',
                'fire'          => 'Fire',
                'flask'         => 'Flask',
                'flower'        => 'Flower',
                'horseshoe'     => 'Horseshoe',
                'hourglass'     => 'Hourglass',
                'hydra'         => 'Hydra',
                'kaleidoscope'  => 'Kaleidoscope',
                'key'           => 'Key',
                'lever'         => 'Lever',
                'meat'          => 'Meat',
                'octopus'       => 'Octopus',
                'palm-tree'     => 'Palm Tree',
                'pin'           => 'Pin',
                'pine-tree'     => 'Pine Tree',
                'player'        => 'Character',
                'potion'        => 'Potion',
                'reactor'       => 'Reactor',
                'repair'        => 'Repair',
                'sheep'         => 'Sheep',
                'shield'        => 'Shield',
                'skull'         => 'Skull',
                'snake'         => 'Snake',
                'spades-card'   => 'Spades Card',
                'sprout'        => 'Sprout',
                'sun'           => 'Sun',
                'tentacle'      => 'Tentacle',
                'toast'         => 'Toast',
                'tombstone'     => 'Tombstone',
                'torch'         => 'Torch',
                'tower'         => 'Tower',
                'vase'          => 'Vase',
                'water-drop'    => 'Water',
                'wooden-sign'   => 'Quest',
                'wrench'        => 'Wrench',
            ],
            'modal'         => 'Create or edit a map point',
            'placeholders'  => [
                'axis_x'    => 'Left position',
                'axis_y'    => 'Top position',
                'name'      => 'Label of the point when no location is provided.',
            ],
            'return'        => 'Back to :name',
            'shapes'        => [
                'circle'    => 'Circle',
                'custom'    => 'Custom',
                'square'    => 'Square',
            ],
            'sizes'         => [
                'custom'    => 'Custom',
                'huge'      => 'Huge',
                'large'     => 'Large',
                'small'     => 'Small',
                'standard'  => 'Standard',
                'tiny'      => 'Tiny',
            ],
            'success'       => [
                'create'    => 'Location Map Point created.',
                'delete'    => 'Location Map Point removed.',
                'update'    => 'Location Map Point updated.',
            ],
            'title'         => 'Location :name Map Points',
        ],
        'success'   => 'Map Points saved.',
    ],
    'maps'          => [
        'title' => 'Location :name Maps',
    ],
    'organisations' => [
        'title' => 'Location :name Organisations',
    ],
    'panels'        => [
        'map'   => 'Map',
    ],
    'placeholders'  => [
        'location'  => 'Choose a parent location',
        'name'      => 'Name of the location',
        'type'      => 'City, Kingdom, Ruin',
    ],
    'show'          => [
        'tabs'  => [
            'characters'    => 'Characters',
            'locations'     => 'Locations',
            'map'           => 'Map',
            'maps'          => 'Maps',
        ],
    ],
];
