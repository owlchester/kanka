<?php

return [
    'create'        => [
        'title' => 'New Creature',
    ],
    'creatures'     => [
        'title' => ':name Sub-creatures',
    ],
    'fields'        => [
        'creature'  => 'Parent Creature',
        'creatures' => 'Sub-creatures',
        'locations' => 'Locations',
    ],
    'helpers'       => [
        'nested_without'    => 'Displaying all creatures that don\'t have a parent creature. Click on a row to see the children creatures.',
    ],
    'placeholders'  => [
        'name'  => 'Name of the creature',
        'type'  => 'Herbivore, Aquatic, Mythical',
    ],
    'show'          => [
        'tabs'  => [
            'creatures' => 'Sub-creatures',
        ],
    ],
];
