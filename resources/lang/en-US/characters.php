<?php

return [
    'show' => [
        'tabs' => [
            'organisations' => 'Organizations',
        ]
    ],
    'organisations' => [
        'create' => [
            'description' => 'Associate an organization to a character',
            'success' => 'Character added to organization.',
        ],
        'actions' => [
            'add' => 'Add organization',
        ],
        'edit' => [
            'title' => 'Update Organization for :name',
            'success' => 'Character organization updated.',
        ],
        'fields' => [
            'organisation' => 'Organization',
        ],
        'placeholders' => [
            'organisation' => 'Choose an organization...',
        ],
        'destroy' => [
            'success' => 'Character organization removed.',
        ]
    ],
];
