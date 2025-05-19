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
        'new'   => 'Add a new post to this entity.',
        'visibility' => 'Change the visibility of the post :name.',
    ],
    'move' => [
        'title' => 'Move post',
        'helper' => 'Move or copy the post :name to a different entity.',
        'copy' => [
            'helper' => 'Keep a copy of the post on :name.',
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
    'visibility' => [
        'title' => 'Post visibility',
        'helper' => 'Change the visibility for the post :name.',
    ],
];
