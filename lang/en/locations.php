<?php

return [
    'characters'    => [
        'title' => 'Location :name Characters',
    ],
    'create'        => [
        'title' => 'New Location',
    ],
    'events'        => [
        'title' => 'Location :name Events',
    ],
    'families'      => [
        'title' => 'Location :name Families',
    ],
    'fields'        => [
        'characters'        => 'Characters',
        'location'          => 'Parent Location',
        'locations'         => 'Locations',
    ],
    'helpers'       => [
        'characters'        => 'View all characters in this location and its children locations, or just those directly located here.',
        'descendants'       => 'This list contains all locations which are descendants of this location, not only those directly under it.',
        'nested_without'    => 'Displaying all locations that don\'t have a parent location. Click on a row to see the children locations.',
    ],
    'locations'     => [
        'title' => 'Location :name Locations',
    ],
    'placeholders'  => [
        'location'  => 'Choose a parent location',
        'name'      => 'Name of the location',
        'type'      => 'City, Kingdom, Ruin',
    ],
];
