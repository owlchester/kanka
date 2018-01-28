<?php

return [
    'create'        => [
        'success'   => 'Organization \':name\' created.',
        'title'     => 'Create a new organization',
    ],
    'destroy'       => [
        'success'   => 'Organization \':name\' removed.',
    ],
    'edit'          => [
        'success'   => 'Organization \':name\' updated.',
        'title'     => 'Edit Organization :name',
    ],
    'index'         => [
        'add'           => 'New Organization',
        'description'   => 'Manage the organizations of :name.',
        'header'        => 'Organizations of :name',
        'title'         => 'Organizations',
    ],
    'members'       => [
        'create'    => [
            'description'   => 'Add a member to the organization',
            'success'       => 'Member added to the organization.',
            'title'         => 'New Organization Member for :name',
        ],
        'destroy'   => [
            'success'   => 'Member removed from the organization.',
        ],
        'edit'      => [
            'success'   => 'Organization member updated.',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Name of the organization',
    ],
    'show'          => [
        'description'   => 'A detailed view of an organization',
        'title'         => 'Organization :name',
    ],
];
