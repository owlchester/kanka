<?php

return [
    'index' => [
        'title' => 'Organizations',
        'description' => 'Manage the organizations of :name.',
        'add' => 'New Organization',
        'header' => 'Organizations of :name',
    ],
    'create' => [
        'title' => 'Create a new organization',
        'success' => 'Organization \':name\' created.',
    ],
    'show' => [
        'title' => 'Organization :name',
        'description' => 'A detailed view of an organization',
    ],
    'edit' => [
        'title' => 'Edit Organization :name',
        'success' => 'Organization \':name\' updated.',
    ],
    'destroy' => [
        'success' => 'Organization \':name\' removed.',
    ],
    'placeholders' => [
        'name' => 'Name of the organization',
    ],
    'members' => [
        'create' => [
            'title' => 'New Organization Member for :name',
            'description' => 'Add a member to the organization',
            'success' => 'Member added to the organization.',
        ],
        'edit' => [
            'success' => 'Organization member updated.',
        ],
        'destroy' => [
            'success' => 'Member removed from the organization.',
        ]
    ],
];
