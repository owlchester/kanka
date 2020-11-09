<?php

return [
    'actions'       => [],
    'fields'        => [
        'eye'   => 'Eye color',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Add organization',
        ],
        'create'        => [
            'description'   => 'Associate an organization to a character',
            'success'       => 'Character added to organization.',
            'title'         => 'New Organization for :name',
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
    ],
    'placeholders'  => [
        'eye'   => 'Eye color',
    ],
    'show'          => [
        'tabs'  => [
            'organisations' => 'Organizations',
        ],
    ],
];
