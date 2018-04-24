<?php

return [
    'create'        => [
        'description'   => 'Create a new journal',
        'success'       => 'Journal \':name\' created.',
        'title'         => 'New Journal',
    ],
    'destroy'       => [
        'success'   => 'Journal \':name\' removed.',
    ],
    'edit'          => [
        'description'   => '',
        'success'       => 'Journal \':name\' updated.',
        'title'         => 'Edit Journal :name',
    ],
    'fields'        => [
        'author'    => 'Author',
        'date'      => 'Date',
        'history'   => 'History',
        'image'     => 'Image',
        'name'      => 'Name',
        'relation'  => 'Relation',
        'type'      => 'Type',
    ],
    'index'         => [
        'add'           => 'New Journal',
        'description'   => 'Manage the journals of :name.',
        'header'        => 'Journals of :name',
        'title'         => 'Journals',
    ],
    'placeholders'  => [
        'author'    => 'Who wrote the journal',
        'date'      => 'Date of the journal',
        'name'      => 'Name of the journal',
        'type'      => 'Session, One Shot, Draft',
    ],
    'show'          => [
        'description'   => 'A detailed view of a journal',
        'title'         => 'Journal :name',
    ],
];
