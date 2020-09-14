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
        'success'   => 'Note \':name\' updated.',
        'title'     => 'Edit Note :name',
    ],
    'fields'        => [
        'description'   => 'Description',
        'image'         => 'Image',
        'is_pinned'     => 'Pinned',
        'name'          => 'Name',
        'note'          => 'Parent Note',
        'notes'         => 'Sub Notes',
        'type'          => 'Type',
    ],
    'helpers'       => [
        'nested'    => 'Displaying notes that have no parent note first. Click on a note to explore it\'s sub notes.',
    ],
    'hints'         => [
        'is_pinned' => 'Up to 3 notes can be pinned to be displayed on the dashboard.',
    ],
    'index'         => [
        'add'           => 'New Note',
        'description'   => 'Manage the notes of :name.',
        'header'        => 'Notes of :name',
        'title'         => 'Notes',
    ],
    'placeholders'  => [
        'name'  => 'Name of the note',
        'note'  => 'Choose a parent note',
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
