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
        'journal'   => 'Parent Journal',
        'journals'  => 'Sub Journals',
        'name'      => 'Name',
        'relation'  => 'Relation',
        'type'      => 'Type',
    ],
    'helpers'       => [
        'journals'      => 'Display all or only the direct sub journals of this journal.',
        'nested_parent' => 'Displaying the journals of :parent.',
        'nested_without'=> 'Displaying all journals that don\'t have a parent journal. Click on a row to see the children journals.',
    ],
    'index'         => [
        'add'           => 'New Journal',
        'description'   => 'Manage the journals of :name.',
        'header'        => 'Journals of :name',
        'title'         => 'Journals',
    ],
    'journals'      => [
        'title' => 'Journal :name sub journals',
    ],
    'placeholders'  => [
        'author'    => 'Who wrote the journal',
        'date'      => 'Real world date of the journal',
        'journal'   => 'Choose a parent journal',
        'name'      => 'Name of the journal',
        'type'      => 'Session, One Shot, Draft',
    ],
    'show'          => [
        'description'   => 'A detailed view of a journal',
        'tabs'          => [
            'journals'  => 'Journals',
        ],
        'title'         => 'Journal :name',
    ],
];
