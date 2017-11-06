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
        'success' => 'Organisation created.',
    ],
    'show' => [
        'title' => 'Organisation :organisation',
        'description' => 'A detailed view of an organisation',
        'actions' => [
            'add_member' => 'Add a member',
        ]
    ],
    'edit' => [
        'title' => 'Edit Organisation :organisation',
        'description' => '',
        'success' => 'Organisation updated.',
    ],
    'destroy' => [
        'success' => 'Organisation removed.',
    ],

    'fields' => [
        'name' => 'Name',
        'type' => 'Type',
        'location' => 'Location',
        'members' => 'Members',
        'image' => 'Image',
        'history' => 'History'
    ],
    'placeholders' => [
        'name' => 'Name of the organisation',
        'location' => 'Choose a location',
        'type' => 'Cult, Gang, Rebelion, Fandom'
    ],

    'members' => [
        'create' => [
            'title' => 'New Organisation Member for :name',
            'description' => 'Add a member to the organisation',
        ],
        'fields' => [
            'role' => 'Role',
            'character' => 'Character',
        ],
        'placeholders' => [
            'role' => 'Leader, Member, High Septon, Spymaster',
            'character' => 'Choose a character'
        ],
    ]
];
