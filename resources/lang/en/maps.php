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
    'destroy'       => [
        'success'   => 'Map :name removed.',
    ],
    'edit'          => [
        'success'   => 'Map :name updated.',
        'title'     => 'Edit Map :name',
    ],
    'errors'        => [
        'dashboard' => [
            'missing'   => 'This map needs an image to be able to render on the dashboard.',
        ],
        'explore'   => [
            'missing'   => 'Please add an image to the map before being able to explore it.',
        ],
        'chunking' => [
            'error' => 'There was an error while chunking the map. Please contact the team on :discord for support.',
            'running' => [
                'edit' => 'The map cannot be edited while it\'s been chunked.',
                'explore' => 'The map cannot be displayed while it\'s been chunked.',
                'time' => 'This can take several minutes to several hours, depending on the size of the map.',
            ]
        ]
    ],
    'fields'        => [
        'center_marker'     => 'Marker',
        'center_x'          => 'Default Longitude Position',
        'center_y'          => 'Default Latitude Position',
        'centering'         => 'Centering',
        'distance_measure'  => 'Distance Measure',
        'distance_name'     => 'Distance Unit',
        'grid'              => 'Grid',
        'initial_zoom'      => 'Initial zoom',
        'is_real'           => 'Use OpenStreetMaps',
        'map'               => 'Parent Map',
        'maps'              => 'Maps',
        'max_zoom'          => 'Maximal zoom',
        'min_zoom'          => 'Minimal zoom',
        'name'              => 'Name',
        'tabs'              => [
            'coordinates'   => 'Coordinates',
            'marker'        => 'Marker',
        ],
        'type'              => 'Type',
    ],
    'helpers'       => [
        'center'            => 'Changing the following values will control which area of the map is focused on. Leaving these values empty will result in the center of the map being focued on.',
        'centering'         => 'Centering on a marker will take priority on default coordinates.',
        'descendants'       => 'This list contains all maps which are descendants of this map, and not only those directly under it.',
        'distance_measure'  => 'Giving the map a distance measurement will enable the measurement tool on the exploration mode.',
        'grid'              => 'Define a grid size that will be displayed on the exploration mode.',
        'initial_zoom'      => 'The initial zoom level a map is loaded with. The default value is :default, while the highest allowed value is :max and the lowest allowed value is :min.',
        'is_real'           => 'Select this option if you want to use a real world map instead of the uploaded image. This option disable layers.',
        'max_zoom'          => 'The most a map can be zoomed in on. The default value is :default, while the highest allowed value is :max.',
        'min_zoom'          => 'The most a map can be zoomed out of. The default value is :default, while the lowest allowed value is :min.',
        'missing_image'     => 'Save the map with an image before being able to add layers and markers.',
        'nested_parent'     => 'Displaying the maps of :parent.',
        'nested_without'    => 'Displaying all maps that don\'t have a parent map. Click on a row to see the children maps.',
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
        'center_marker'     => 'Leave empty to load the map in the middle',
        'center_x'          => 'Leave empty to load the map in the middle',
        'center_y'          => 'Leave empty to load the map in the middle',
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
    'tooltips' => [
        'chunking' => [
            'running' => 'Map is being chunked.',
        ]
    ]
];
