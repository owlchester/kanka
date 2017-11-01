<?php

return [
    'index' => [
        'title' => 'Organisations',
        'description' => 'Manage the organisations of your campaign.',
        'add' => 'New Organisation',
        'header' => 'Organisations of :name',
    ],
    'create' => [
        'title' => 'Create a new organisation',
        'description' => '',
    ],
    'show' => [
        'title' => 'Organisation :organisation',
        'description' => 'A detailed view of an organisation',
    ],
    'edit' => [
        'title' => 'Edit Organisation :organisation',
        'description' => ''
    ],

    'fields' => [
        'name' => 'Name',
        'type' => 'Type',
        'location' => 'Location',
        'members' => 'Members',
    ],

    'members' => [
        'create' => [
            'title' => 'New Organisation Member for :name',
            'description' => 'Add a member to the organisation',
        ],
        'fields' => [
            'role' => 'Role',
        ]
    ]
];
