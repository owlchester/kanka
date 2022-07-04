<?php

return [
    'create'        => [
        'title' => 'New Journal',
    ],
    'fields'        => [
        'author'    => 'Author',
        'date'      => 'Date',
        'image'     => 'Image',
        'journal'   => 'Parent Journal',
        'journals'  => 'Sub Journals',
        'name'      => 'Name',
        'type'      => 'Type',
    ],
    'helpers'       => [
        'journals'      => 'Display all or only the direct sub journals of this journal.',
        'nested_without'=> 'Displaying all journals that don\'t have a parent journal. Click on a row to see the children journals.',
    ],
    'index'         => [
        'title' => 'Journals',
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
        'tabs'  => [
            'journals'  => 'Journals',
        ],
    ],
];
