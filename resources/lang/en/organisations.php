<?php

return [
    'index' => [
        'title' => 'Organisations',
        'description' => 'Manage the organisations of :name.',
        'add' => 'New Organisation',
        'header' => 'Organisations of :name',
    ],
    'create' => [
        'title' => 'Create a new organisation',
        'description' => '',
        'success' => 'Organisation \':name\' created.',
    ],
    'show' => [
        'title' => 'Organisation :name',
        'description' => 'A detailed view of an organisation',
        'tabs' => [
            'history' => 'History',
            'members' => 'Members',
            'relations' => 'Relations',
        ]
    ],
    'edit' => [
        'title' => 'Edit Organisation :name',
        'description' => '',
        'success' => 'Organisation \':name\' updated.',
    ],
    'destroy' => [
        'success' => 'Organisation \':name\' removed.',
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
            'success' => 'Member added to the organisation.',
        ],
        'actions' => [
            'add' => 'Add a member',
        ],
        'edit' => [
            'title' => 'Update Member for :name',
            'description' => '',
            'success' => 'Organisation member updated.',
        ],
        'fields' => [
            'role' => 'Role',
            'character' => 'Character',
        ],
        'placeholders' => [
            'role' => 'Leader, Member, High Septon, Spymaster',
            'character' => 'Choose a character'
        ],
        'destroy' => [
            'success' => 'Member removed from the organisation.',
        ]
    ],
    'relations' => [
        'create' => [
            'title' => 'New Organisation Relation for :name',
            'description' => 'Create a new relation between two organisations',
            'success' => 'Relation created.',
        ],
        'edit' => [
            'title' => 'Update Relation for :name',
            'description' => '',
            'success' => 'Relation updated.',
        ],
        'actions' => [
            'add' => 'Add a relation',
        ],
        'fields' => [
            'second' => 'Organisation',
            'relation' => 'Relation',
            'two_way' => 'Create mirror relation',
        ],
        'placeholders' => [
            'second' => 'Choose an organisation',
            'relation' => 'Nature of the relation',
        ],
        'hints' => [
            'two_way' => 'If you select to create a mirror relation, the same relation will be created on the target. However, if you edit one, the mirror won\'t be updated.',
        ],
        'destroy' => [
            'success' => 'Relation removed.',
        ],
    ]
];
