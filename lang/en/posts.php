<?php

return [
    'create'        => [
        'template'  => [
            'helper'    => 'The campaign admins have defined the following posts as templates that can be re-used.',
        ],
        'title'     => 'New Post',
    ],
    'fields'        => [
        'name'  => 'Name',
    ],
    'helpers'       => [
        'new'           => 'Add a new post to this entity.',
        'visibility'    => 'Change the visibility of the post :name.',
    ],
    'move'          => [
        'copy'      => [
            'helper'    => 'Keep a copy of the post on :name.',
        ],
        'helper'    => 'Move or copy the post :name to a different entity.',
        'title'     => 'Move post',
    ],
    'permissions'   => [
        'actions'   => [
            'members'   => 'Add members',
            'roles'     => 'Add roles',
        ],
        'helpers'   => [
            'members'   => 'Add one or multiple members to have special permissions on this post.',
            'roles'     => 'Add one or multiple roles to have special permissions on this post.',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Name of the post',
    ],
    'position'      => [
        'dont_change'   => 'Don\'t change',
        'first'         => 'First',
        'last'          => 'Last',
    ],
    'remove'        => [
        'title' => 'Remove post',
    ],
    'visibility'    => [
        'helper'    => 'Change the visibility for the post :name.',
        'title'     => 'Post visibility',
    ],
];
