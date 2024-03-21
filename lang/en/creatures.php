<?php

return [
    'create'        => [
        'title' => 'New Creature',
    ],
    'fields'        => [
        'is_extinct'    => 'Extinct',
    ],
    'helpers'       => [
        'nested_without'    => 'Displaying all creatures that don\'t have a parent creature. Click on a row to see the children creatures.',
    ],
    'hints'         => [
        'is_extinct'    => 'This creature is extinct.',
    ],
    'placeholders'  => [
        'type'  => 'Herbivore, Aquatic, Mythical',
    ],
];
