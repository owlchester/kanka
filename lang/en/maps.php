<?php

return [
    'actions'       => [
        'back'      => 'Back to :name',
        'edit'      => 'Edit map',
        'explore'   => 'Explore',
    ],
    'create'        => [
        'title' => 'New Map',
    ],
    'errors'        => [
        'chunking'  => [
            'error'     => 'There was an error while chunking the map. Please contact the team on :discord for support.',
            'running'   => [
                'edit'      => 'The map cannot be edited while it\'s been chunked.',
                'explore'   => 'The map cannot be displayed while it\'s been chunked.',
                'time'      => 'This can take several minutes to several hours, depending on the size of the map.',
            ],
        ],
        'dashboard' => [
            'missing'   => 'This map needs an image to be able to render on the dashboard.',
        ],
        'explore'   => [
            'missing'   => 'Please add an image to the map before being able to explore it.',
        ],
    ],
    'fields'        => [
        'center_marker'     => 'Marker',
        'center_x'          => 'Default Longitude Position',
        'center_y'          => 'Default Latitude Position',
        'centering'         => 'Centering',
        'distance_measure'  => 'Distance measurement',
        'distance_name'     => 'Distance unit label',
        'grid'              => 'Grid',
        'has_clustering'    => 'Cluster markers',
        'initial_zoom'      => 'Initial zoom',
        'is_real'           => 'Use OpenStreetMaps',
        'max_zoom'          => 'Maximal zoom',
        'min_zoom'          => 'Minimal zoom',
        'tabs'              => [
            'coordinates'   => 'Coordinates',
            'marker'        => 'Marker',
        ],
    ],
    'helpers'       => [
        'center'                => 'Changing the following values will control which area of the map is focused on. Leaving these values empty will result in the center of the map being focued on.',
        'centering'             => 'Centering on a marker will take priority on default coordinates.',
        'chunked_zoom'          => 'Automatically cluster markers together when they are close to each other.',
        'distance_measure'      => 'Giving the map a distance measurement will enable the measurement tool in the exploration mode.',
        'distance_measure_2'    => 'For 100 pixels to measure 1 kilometer, input a value of 0.0041.',
        'grid'                  => 'Define a grid size that will be displayed in the exploration mode. A value below 10 will result in a greyed out map.',
        'has_clustering'        => 'Automatically cluster markers together when they are close to each other.',
        'initial_zoom'          => 'The initial zoom level a map is loaded with. The default value is :default, while the highest allowed value is :max and the lowest allowed value is :min.',
        'is_real'               => 'Select this option if you want to use a real world map instead of the uploaded image. This option disable layers.',
        'max_zoom'              => 'The most a map can be zoomed in on. The default value is :default, while the highest allowed value is :max.',
        'min_zoom'              => 'The most a map can be zoomed out of. The default value is :default, while the lowest allowed value is :min.',
        'missing_image'         => 'Save the map with an image before being able to add layers and markers.',
    ],
    'lists'         => [
        'empty' => 'Upload a map to visualize locations and reveal the geography of your world.',
    ],
    'panels'        => [
        'groups'    => 'Groups',
        'layers'    => 'Layers',
        'legend'    => 'Legend',
        'markers'   => 'Markers',
        'settings'  => 'Settings',
    ],
    'placeholders'  => [
        'center_marker' => 'Leave empty to load the map in the middle',
        'center_x'      => 'Leave empty to load the map in the middle',
        'center_y'      => 'Leave empty to load the map in the middle',
        'distance_name' => 'Km, miles, feet, hamburgers',
        'grid'          => 'Distance in pixel between grid elements. Leave empty to hide the grid.',
        'name'          => 'Name of the map',
        'type'          => 'Dungeon, City, Galaxy',
    ],
    'show'          => [
        'tabs'  => [
            'maps'  => 'Maps',
        ],
    ],
    'tooltips'      => [
        'chunking'  => [
            'running'   => 'Map is being chunked. This process can take several minutes to hours.',
        ],
    ],
];
