<?php

return [
    'create'        => [
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
        'nested_parent' => 'Displaying the notes of :parent.',
        'nested_without'=> 'Displaying all notes that don\'t have a parent note. Click on a row to see the children notes.',
    ],
    'hints'         => [
        'is_pinned' => 'Up to 3 notes can be pinned to be displayed on the dashboard.',
    ],
    'index'         => [
        'add'           => 'New Note',
        'header'        => 'Notes of :name',
        'title'         => 'Notes',
    ],
    'placeholders'  => [
        'name'  => 'Name of the note',
        'note'  => 'Choose a parent note',
        'type'  => 'Religion, Race, Political system',
    ],
    'show'          => [
        'title'         => 'Note :name',
    ],
];
