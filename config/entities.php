<?php

return [
    'hard_delete' => env('APP_ENTITY_HARD_DELETE', 30),
    'logs' => env('APP_ENTITY_FULL_LOGS', 30),
    'logs_delete' => env('APP_ENTITY_LOGS_DELETE', 365),

    'ids' => [
        'character' => 1,
        'family' => 2,
        'location' => 3,
        'organisation' => 4,
        'item' => 5,
        'note' => 6,
        'event' => 7,
        'calendar' => 8,
        'race' => 9,
        'quest' => 10,
        'journal' => 11,
        'tag' => 12,
        'dice_roll' => 13,
        'conversation' => 14,
        'attribute_template' => 15,
        'ability' => 16,
        'map' => 17,
        'timeline' => 18,
        'menu_link' => 19,
    ],
];
