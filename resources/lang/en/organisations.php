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
        'success'   => 'Organisation \':name\' updated.',
        'title'     => 'Edit Organisation :name',
    ],
    'fields'        => [
        'image'         => 'Image',
        'location'      => 'Location',
        'members'       => 'Members',
        'name'          => 'Name',
        'organisation'  => 'Parent Organisation',
        'relation'      => 'Relation',
        'type'          => 'Type',
    ],
    'helpers'       => [
        'descendants'   => 'This list contains all organisations which are descendants of this organisation, not only those directly under it.',
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
            'success'   => 'Organisation member updated.',
            'title'     => 'Update Member for :name',
        ],
        'fields'        => [
            'character' => 'Character',
            'role'      => 'Role',
        ],
        'helpers'       => [
            'all_members'       => 'The following list are all characters that are in this organisation and all of the organisation\'s descendant organisations.',
            'direct_members'    => 'Most organisations require members to run successfully. The following list are characters that are directly in this organisation.',
        ],
        'placeholders'  => [
            'character' => 'Choose a character',
            'role'      => 'Leader, Member, High Septon, Spymaster',
        ],
        'title'         => 'Organisation :name Members',
    ],
    'organisations' => [
        'title' => 'Organisation :name Organisations',
    ],
    'placeholders'  => [
        'location'  => 'Choose a location',
        'name'      => 'Name of the organisation',
        'type'      => 'Cult, Gang, Rebellion, Fandom',
    ],
    'quests'        => [
        'description'   => 'Quests the organisation is a part of.',
        'title'         => 'Organisation :name Quests',
    ],
    'show'          => [
        'description'   => 'A detailed view of an organisation',
        'tabs'          => [
            'all_members'   => 'All Members',
            'members'       => 'Direct Members',
            'organisations' => 'Organisations',
            'quests'        => 'Quests',
            'relations'     => 'Relations',
        ],
        'title'         => 'Organisation :name',
    ],
];
