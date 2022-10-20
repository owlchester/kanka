<?php

return [
    'create'        => [
        'title' => 'New Note',
    ],
    'fields'        => [
        'is_pinned'     => 'Pinned',
        'note'          => 'Parent Note',
        'notes'         => 'Sub Notes',
    ],
    'helpers'       => [
        'nested_without'    => 'Displaying all notes that don\'t have a parent note. Click on a row to see the children notes.',
    ],
    'hints'         => [
        'is_pinned' => 'Up to 3 notes can be pinned to be displayed on the dashboard.',
    ],
    'placeholders'  => [
        'name'  => 'Name of the note',
        'note'  => 'Choose a parent note',
        'type'  => 'Religion, Race, Political system',
    ],
];
