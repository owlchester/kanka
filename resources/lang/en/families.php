<?php

return [
    'index' => [
        'title' => 'Families',
        'description' => 'Manage the families of :name.',
        'add' => 'New Family',
        'header' => 'Families of :name',
    ],
    'create' => [
        'title' => 'Create a new family',
        'description' => '',
        'success' => 'Family \':name\' created.',
    ],
    'show' => [
        'title' => 'Family :name',
        'description' => 'A detailed view of a family',
        'tabs' => [
            'history' => 'History',
            'member' => 'Members',
            'relation' => 'Relations',
        ],
    ],
    'edit' => [
        'title' => 'Edit Family :name',
        'description' => '',
        'success' => 'Family \':name\' updated.',
    ],
    'destroy' => [
        'success' => 'Family \':name\' removed.',
    ],

    'fields' => [
        'relation' => 'Relation',
        'name' => 'Name',
        'location' => 'Location',
        'members' => 'Members',
        'image' => 'Image',
        'history' => 'History',
    ],
    'placeholders' => [
        'name' => 'Name of the family',
        'location' => 'Choose a location',
    ],
];
