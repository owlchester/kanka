<?php

return [
    'create'        => [
        'success'   => 'Organisation \':name\' created.',
        'title'     => 'New Organisation',
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
        'organisations' => 'Sub Organisations',
        'relation'      => 'Relation',
        'type'          => 'Type',
    ],
    'helpers'       => [
        'descendants'   => 'This list contains all organisations which are descendants of this organisation, and not only those directly under it.',
        'nested_parent' => 'Displaying the organisations of :parent.',
        'nested_without'=> 'Displaying all organisations that don\'t have a parent organisation. Click on a row to see the children organisations.',
    ],
    'index'         => [
        'add'       => 'New Organisation',
        'header'    => 'Organisations of :name',
        'title'     => 'Organisations',
    ],
    'members'       => [
        'actions'       => [
            'add'   => 'Add a member',
        ],
        'create'        => [
            'success'   => 'Member added to the organisation.',
            'title'     => 'New Member',
        ],
        'destroy'       => [
            'success'   => 'Member removed from the organisation.',
        ],
        'edit'          => [
            'success'   => 'Organisation member updated.',
            'title'     => 'Update Member for :name',
        ],
        'fields'        => [
            'character'     => 'Character',
            'organisation'  => 'Organisation',
            'pinned'        => 'Pinned',
            'role'          => 'Role',
            'status'        => 'Membership status',
        ],
        'helpers'       => [
            'all_members'   => 'All characters that are members of this organisations and it\'s sub-organisations.',
            'members'       => 'All characters that are members of this organisation.',
            'pinned'        => 'Choose if this member should be shown in the pinned section of the overview of its associated entities.',
        ],
        'pinned'        => [
            'both'          => 'Both',
            'character'     => 'Character',
            'none'          => 'None',
            'organisation'  => 'Organisation',
        ],
        'placeholders'  => [
            'character' => 'Choose a character',
            'role'      => 'Leader, Member, High Septon, Spymaster',
        ],
        'status'        => [
            'active'    => 'Active member',
            'inactive'  => 'Inactive member',
            'unknown'   => 'Unknown status',
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
    'show'          => [
        'tabs'  => [
            'organisations' => 'Organisations',
            'quests'        => 'Quests',
            'relations'     => 'Relations',
        ],
        'title' => 'Organisation :name',
    ],
];
