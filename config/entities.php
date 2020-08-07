<?php

return [
    'max_entity_files' => 3,
    'max_entity_files_boosted' => 5,
    'file_upload' => env('APP_ENTITY_FILE_UPLOAD', false),
    'hard_delete' => env('APP_ENTITY_HARD_DELETE', 31),

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
//        '' => 17,
//        '' => 18,
//        '' => 19,
    ]
];
