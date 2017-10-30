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
    ],
    'show' => [
        'title' => 'Family :family',
        'description' => 'A detailed view of a family',
    ],
    'edit' => [
        'title' => 'Edit Family :family',
        'description' => ''
    ],

    'fields' => [
        'relation' => 'Relation',
        'name' => 'Name',
        'location' => 'Location',
        'members' => 'Members',
    ],

    'relations' => [
        'create' => [
            'title' => 'New Family Relation for :name',
            'description' => 'Create a new relation between two families',
        ],
    ]
];
