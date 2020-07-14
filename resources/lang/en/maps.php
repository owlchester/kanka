<?php

return [
    'actions' => [
        'explore' => 'Explore',
        'edit' => 'Edit map',
        'back' => 'Back to :name',
    ],
    'create' => [
        'title' => 'New Map',
        'success' => 'Map :name created.',
    ],
    'edit' => [
        'title' => 'Edit Map :name',
        'success' => 'Map :name updated.',
    ],
    'fields' => [
        'distance_name' => 'Distance Unit',
        'distance_measure' => 'Distance Measure',
        'grid' => 'Grid',
        'name' => 'Name',
        'type' => 'Type',
        'map' => 'Parent Map',
        'maps' => 'Maps'
    ],
    'index' => [
        'title' => 'Maps',
        'add' => 'New Map',
    ],
    'maps' => [
        'title' => 'Maps of :name',
    ],
    'panels' => [
        'layers' => 'Layers',
        'markers' => 'Markers',
        'settings' => 'Settings',
    ],
    'placeholders' => [
        'distance_name' => 'Name of the distance unit (kilometer, mile)',
        'distance_measure' => 'Units per pixel',
        'grid' => 'Distance in pixel between grid elements. Leave empty to hide the grid.',
        'name' => 'Name of the map',
        'type' => 'Dungeon, City, Galaxy',
    ],
    'show' => [
        'title' => 'Map :name',
        'tabs' => [
            'maps' => 'Maps',
        ],
    ],
    'helpers' => [
        'grid'              => 'Define a grid size that will be displayed on the exploration mode.',
        'descendants'   => 'This list contains all maps which are descendants of this map, and not only those directly under it.',
        'distance_measure' => 'Giving the map a distance measurement will enable the measurement tool on the exploration mode. You will have to play around with this value for a while. We suggest starting with 50000.',
        'nested'        => 'When in Nested View, you can view your Maps in a nested manner. Maps with no parent map will be shown by default. Maps with children tags can be clicked to view those children. You can keep clicking until there are no more children to view.',

        'missing_image' => 'Save the map with an image before being able to add layers and markers.',
    ]
];
