<?php

return [
    'create'        => [
        'title' => 'New Article',
    ],
    'fields'        => [
        'description'   => 'Description',
        'layout'        => 'Article layout',
        'name'          => 'Article name',
    ],
    'helpers'       => [
        'new'           => 'Add a new article to this entry.',
        'visibility'    => 'Change the visibility of the :name article.',
    ],
    'move'          => [
        'copy'      => [
            'helper'    => 'Keep a copy of the article on :name.',
        ],
        'helper'    => 'Move or copy the article :name to a different entry.',
        'title'     => 'Move article',
    ],
    'permissions'   => [
        'actions'   => [
            'members'   => 'Add members',
            'roles'     => 'Add roles',
        ],
        'helpers'   => [
            'members'   => 'Add one or multiple members to have special permissions on this article.',
            'roles'     => 'Add one or multiple roles to have special permissions on this article.',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Name of the article',
    ],
    'position'      => [
        'dont_change'   => 'Don\'t change',
        'first'         => 'First',
        'last'          => 'Last',
    ],
    'remove'        => [
        'title' => 'Remove article',
    ],
    'visibility'    => [
        'helper'    => 'Change the visibility for the :name article.',
        'title'     => 'Article visibility',
    ],
];
