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
    'placeholders'  => [
        'name'  => 'Name of the post',
    ],
    'position'      => [
        'dont_change'   => 'Don\'t change',
        'first'         => 'First',
        'last'          => 'Last',
    ],
];
