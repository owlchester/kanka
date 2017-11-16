<?php

return [
    'index' => [
        'title' => 'Journals',
        'description' => 'Manage the journals of your campaign.',
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
        'is_private' => 'Private',
    ],
    'placeholders' => [
        'name' => 'Name of the journal',
        'type' => 'Session, One Shot, Draft',
        'date' => 'Date of the journal',
    ],
    'hints' => [
        'is_private' => 'Hide from "Viewers"',
    ],
    'helpers' => [
        'title' => 'Head\'s up!',
        'description' => 'You can easily write links to characters by writing <code>{character:Michael Snow}</code> in the textarea. On submitting, it will be replaced with a link to the named entity. The same thing is available for <i>family:</i>, <i>item:</i>, <i>location:</i>, <i>journal:</i>, <i>note:</i> and <i>organisation:</i>.',
    ],
];
