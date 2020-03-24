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
    'fields'        => [
        'organisation'  => 'Parent Organization',
    ],
    'helpers'       => [
        'descendants'   => 'This list contains all organizations which are descendants of this organization, and not only those directly under it.',
        'nested'        => 'When in Nested View, you can view your Organizations in a nested manner. Organizations with no parent organization will be shown by default. Organizations with children tags can be clicked to view those children. You can keep clicking until there are no more children to view.',
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
        'title'     => 'Organization :name Members',
    ],
    'organisations' => [
        'title' => 'Organization :name Organizations',
    ],
    'placeholders'  => [
        'name'  => 'Name of the organization',
    ],
    'show'          => [
        'description'   => 'A detailed view of an organization',
        'tabs'          => [
            'organisations' => 'Organizations',
        ],
        'title'         => 'Organization :name',
    ],
];
