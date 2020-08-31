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
        'type'          => 'Type',
        'note'          => 'Parent Note',
        'notes'         => 'Sub Notes',
    ],
    'helpers'       => [
        'nested' => 'Displaying notes that have no parent note first. Click on a note to explore it\'s sub notes.',
    ],
    'hints'         => [
        'is_pinned' => 'Up to 3 notes can be pinned to be displayed on the dashboard.',
        'parent_note' => ''
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
        'note' => 'Choose a parent note',
    ],
    'show'          => [
        'description'   => 'A detailed view of a note',
        'tabs'          => [
            'description'   => 'Description',
        ],
        'title'         => 'Note :name',
    ],
];
