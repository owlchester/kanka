<?php

return [
    'index' => [
        'title' => 'Families',
        'description' => 'Manage the families of your campaign.',
        'add' => 'New Family',
        'header' => 'Families of :name',
    ],
    'create' => [
        'title' => 'Create a new family',
        'description' => '',
        'success' => 'Family created.',
    ],
    'show' => [
        'title' => 'Family :family',
        'description' => 'A detailed view of a family',
        'tabs' => [
            'history' => 'History',
            'member' => 'Members',
            'relation' => 'Relations',
        ],
    ],
    'edit' => [
        'title' => 'Edit Family :family',
        'description' => '',
        'success' => 'Family updated.',
    ],
    'destroy' => [
        'success' => 'Family removed.',
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

    'relations' => [
        'create' => [
            'title' => 'New Family Relation for :name',
            'description' => 'Create a new relation between two families',
        ],
        'actions' => [
            'add' => 'Add a relation',
        ],
        'fields' => [
            'second' => 'Family',
            'relation' => 'Relation'
        ],
        'placeholders' => [
            'second' => 'Choose a family',
            'relation' => 'Ally, Enemy, Vassal'
        ]
    ]
];
