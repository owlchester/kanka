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
        'title' => 'Organisation :name',
        'description' => 'A detailed view of an organisation',
        'actions' => [
            'add_member' => 'Add a member',
        ],
        'tabs' => [
            'history' => 'History',
            'members' => 'Members',
            'relations' => 'Relations',
        ]
    ],
    'edit' => [
        'title' => 'Edit Organisation :name',
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
        'history' => 'History',
        'is_private' => 'Private',
        'relation' => 'Relation',
    ],
    'placeholders' => [
        'name' => 'Name of the organisation',
        'location' => 'Choose a location',
        'type' => 'Cult, Gang, Rebelion, Fandom',
    ],
    'hints' => [
        'is_private' => 'Hide from "Viewers"',
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
    ],
    'relations' => [
        'create' => [
            'title' => 'Organisation Relationships',
            'description' => 'Define the relationship between two organisations',
            'success' => 'Relation created.',
        ],
        'actions' => [
            'add' => 'Add a relation',
        ],
        'fields' => [
            'second' => 'Organisation',
            'relation' => 'Relation',
        ],
        'placeholders' => [
            'second' => 'Choose an organisation',
            'relation' => 'Nature of the relation',
        ],
        'destroy' => [
            'success' => 'Relation removed.',
        ],
    ]
];
