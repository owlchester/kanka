<?php

return [
    'actions'       => [
        'back'      => 'Back to :name',
        'edit'      => 'Edit map',
        'explore'   => 'Explore',
    ],
    'create'        => [
        'success'   => 'Map :name created.',
        'title'     => 'New Map',
    ],
    'edit'          => [
        'success'   => 'Map :name updated.',
        'title'     => 'Edit Map :name',
    ],
    'errors'        => [
        'explore'   => [
            'missing'   => 'Please add an image to the map before being able to explore it.',
        ],
        'dashboard' => [
            'missing' => 'This map needs an image to be able to render on the dashboard.',
        ],
    ],
    'fields'        => [
        'distance_measure'  => 'Distance Measure',
        'distance_name'     => 'Distance Unit',
        'grid'              => 'Grid',
        'map'               => 'Parent Map',
        'maps'              => 'Maps',
        'name'              => 'Name',
        'type'              => 'Type',
    ],
    'helpers'       => [
        'descendants'       => 'This list contains all maps which are descendants of this map, and not only those directly under it.',
        'distance_measure'  => 'Giving the map a distance measurement will enable the measurement tool on the exploration mode.',
        'grid'              => 'Define a grid size that will be displayed on the exploration mode.',
        'missing_image'     => 'Save the map with an image before being able to add layers and markers.',
        'nested'            => 'When in Nested View, you can view your Maps in a nested manner. Maps with no parent map will be shown by default. Maps with children tags can be clicked to view those children. You can keep clicking until there are no more children to view.',
    ],
    'index'         => [
        'add'   => 'New Map',
        'title' => 'Maps',
    ],
    'maps'          => [
        'title' => 'Maps of :name',
    ],
    'panels'        => [
        'groups'    => 'Groups',
        'layers'    => 'Layers',
        'markers'   => 'Markers',
        'settings'  => 'Settings',
    ],
    'placeholders'  => [
        'distance_measure'  => 'Units per pixel',
        'distance_name'     => 'Name of the distance unit (kilometer, mile)',
        'grid'              => 'Distance in pixel between grid elements. Leave empty to hide the grid.',
        'name'              => 'Name of the map',
        'type'              => 'Dungeon, City, Galaxy',
    ],
    'show'          => [
        'tabs'  => [
            'maps'  => 'Maps',
        ],
        'title' => 'Map :name',
    ],
];
