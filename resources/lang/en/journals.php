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
        'success'   => 'Journal \':name\' updated.',
        'title'     => 'Edit Journal :name',
    ],
    'fields'        => [
        'author'    => 'Author',
        'date'      => 'Date',
        'image'     => 'Image',
        'journal' => 'Parent Journal',
        'journals' => 'Sub Journals',
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
        'date'      => 'Real world date of the journal',
        'name'      => 'Name of the journal',
        'journal'   => 'Choose a parent journal',
        'type'      => 'Session, One Shot, Draft',
    ],
    'helpers' => [
        'journals' => 'Display all or only the direct sub journals of this journal.',
        'nested' => 'Displaying journals with no parent journal first. Click on a row to explore the journal\'s sub journals.',
    ],
    'show'          => [
        'description'   => 'A detailed view of a journal',
        'title'         => 'Journal :name',
        'tabs' => [
            'journals' => 'Journals',
        ]
    ],
    'journals' => [
        'title' => 'Journal :name sub journals',
    ]
];
