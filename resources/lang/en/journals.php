<?php

return [
    'index' => [
        'title' => 'Journals',
        'description' => 'Manage the journals of :name.',
        'add' => 'New Journal',
        'header' => 'Journals of :name',
    ],
    'create' => [
        'title' => 'Create a new journal',
        'description' => '',
        'success' => 'Journal created.',
    ],
    'show' => [
        'title' => 'Journal :name',
        'description' => 'A detailed view of a journal',
    ],
    'edit' => [
        'title' => 'Edit Journal :name',
        'description' => '',
        'success' => 'Journal updated.',
    ],
    'destroy' => [
        'success' => 'Journal removed.',
    ],

    'fields' => [
        'relation' => 'Relation',
        'name' => 'Name',
        'type' => 'Type',
        'history' => 'History',
        'date' => 'Date',
        'image' => 'Image',
    ],
    'placeholders' => [
        'name' => 'Name of the journal',
        'type' => 'Session, One Shot, Draft',
        'date' => 'Date of the journal',
    ],
];
