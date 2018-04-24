<?php

return [
    'create'        => [
        'description'   => 'Create a new note',
        'success'       => 'Note \':name\' created.',
        'title'         => 'New Note',
    ],
    'destroy'       => [
        'success'   => 'Note \':name\' removed.',
    ],
    'edit'          => [
        'description'   => '',
        'success'       => 'Note \':name\' updated.',
        'title'         => 'Edit Note :name',
    ],
    'fields'        => [
        'description'   => 'Description',
        'image'         => 'Image',
        'name'          => 'Name',
        'type'          => 'Type',
    ],
    'index'         => [
        'add'           => 'New Note',
        'description'   => 'Manage the notes of :name.',
        'header'        => 'Notes of :name',
        'title'         => 'Notes',
    ],
    'placeholders'  => [
        'name'  => 'Name of the note',
        'type'  => 'Religion, Race, Political system',
    ],
    'show'          => [
        'description'   => 'A detailed view of a note',
        'tabs'          => [
            'description'   => 'Description',
        ],
        'title'         => 'Note :name',
    ],
];
