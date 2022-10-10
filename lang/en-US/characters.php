<?php

return [
    'actions'       => [
        'add_organisation'  => 'Add an organization',
    ],
    'fields'        => [],
    'organisations' => [
        'actions'       => [
            'add'   => 'Add organization',
        ],
        'create'        => [
            'success'   => 'Character added to organization.',
            'title'     => 'New Organization for :name',
        ],
        'destroy'       => [
            'success'   => 'Character organization removed.',
        ],
        'edit'          => [
            'success'   => 'Character organization updated.',
            'title'     => 'Update Organization for :name',
        ],
        'fields'        => [
            'organisation'  => 'Organization',
        ],
        'placeholders'  => [
            'organisation'  => 'Choose an organization...',
        ],
        'title'         => 'Character :name Organizations',
    ],
    'placeholders'  => [],
    'show'          => [
        'tabs'  => [
            'organisations' => 'Organizations',
        ],
    ],
];
