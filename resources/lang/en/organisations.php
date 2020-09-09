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
        'organisations' => 'Sub Organisations',
        'relation'      => 'Relation',
        'type'          => 'Type',
    ],
    'helpers'       => [
        'descendants'   => 'This list contains all organisations which are descendants of this organisation, and not only those directly under it.',
        'nested'        => 'When in Nested View, you can view your Organisations in a nested manner. Organisations with no parent organisation will be shown by default. Organisations with children organisations can be clicked to view those children. You can keep clicking until there are no more children to view.',
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
            'character'     => 'Character',
            'organisation'  => 'Organisation',
            'role'          => 'Role',
        ],
        'helpers'       => [
            'all_members'   => 'All the characters that are members of this organisations and it\'s sub-organisations.',
            'members'       => 'All the characters that are members of this organisation.',
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
            'organisations' => 'Organisations',
            'quests'        => 'Quests',
            'relations'     => 'Relations',
        ],
        'title'         => 'Organisation :name',
    ],
];
