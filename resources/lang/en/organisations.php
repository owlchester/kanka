<?php

return [
    'create'        => [
        'description'   => 'Create a new organisation',
        'success'       => 'Organisation \':name\' created.',
        'title'         => 'New Organisation',
    ],
    'destroy'       => [
        'success'   => 'Organisation \':name\' removed.',
    ],
    'edit'          => [
        'description'   => '',
        'success'       => 'Organisation \':name\' updated.',
        'title'         => 'Edit Organisation :name',
    ],
    'fields'        => [
        'history'   => 'History',
        'image'     => 'Image',
        'location'  => 'Location',
        'members'   => 'Members',
        'name'      => 'Name',
        'relation'  => 'Relation',
        'type'      => 'Type',
    ],
    'index'         => [
        'add'           => 'New Organisation',
        'description'   => 'Manage the organisations of :name.',
        'header'        => 'Organisations of :name',
        'title'         => 'Organisations',
    ],
    'members'       => [
        'actions'       => [
            'add'   => 'Add a member',
        ],
        'create'        => [
            'description'   => 'Add a member to the organisation',
            'success'       => 'Member added to the organisation.',
            'title'         => 'New Organisation Member for :name',
        ],
        'destroy'       => [
            'success'   => 'Member removed from the organisation.',
        ],
        'edit'          => [
            'description'   => '',
            'success'       => 'Organisation member updated.',
            'title'         => 'Update Member for :name',
        ],
        'fields'        => [
            'character' => 'Character',
            'role'      => 'Role',
        ],
        'hint'          => 'Most organisations require members to run successfully.',
        'placeholders'  => [
            'character' => 'Choose a character',
            'role'      => 'Leader, Member, High Septon, Spymaster',
        ],
    ],
    'placeholders'  => [
        'location'  => 'Choose a location',
        'name'      => 'Name of the organisation',
        'type'      => 'Cult, Gang, Rebelion, Fandom',
    ],
    'show'          => [
        'description'   => 'A detailed view of an organisation',
        'tabs'          => [
            'history'   => 'History',
            'members'   => 'Members',
            'relations' => 'Relations',
        ],
        'title'         => 'Organisation :name',
    ],
];
