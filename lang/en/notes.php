<?php

return [
    'create'        => [
        'title' => 'New Note',
    ],
    'fields'        => [
        'notes' => 'Sub Notes',
    ],
    'helpers'       => [
        'nested_without'    => 'Displaying all notes that don\'t have a parent note. Click on a row to see the children notes.',
    ],
    'placeholders'  => [
        'note'  => 'Choose a parent note',
        'type'  => 'Religion, Race, Political system',
    ],
];
