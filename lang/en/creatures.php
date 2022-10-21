<?php

return [
    'create'        => [
        'title' => 'New Creature',
    ],
    'fields'        => [
        'locations'     => 'Locations',
        'creature'      => 'Parent Creature',
        'creatures'     => 'Sub-creatures',
    ],
    'helpers'       => [
        'nested_without'    => 'Displaying all creatures that don\'t have a parent creature. Click on a row to see the children creatures.',
    ],
    'placeholders'  => [
        'name'  => 'Name of the creature',
        'type'  => 'Herbivore, Aquatic, Mythical',
    ],
    'creatures'         => [
        'title' => ':name Sub-creatures',
    ],
    'show'          => [
        'tabs'  => [
            'creatures'         => 'Sub-creatures',
        ],
    ],
];
