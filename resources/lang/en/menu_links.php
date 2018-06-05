<?php

return [
    'create'        => [
        'description'   => 'Create a new menu link',
        'success'       => 'Menu Link \':name\' created.',
        'title'         => 'New Menu Link',
    ],
    'destroy'       => [
        'success'   => 'Menu Link \':name\' removed.',
    ],
    'edit'          => [
        'description'   => '',
        'success'       => 'Menu Link \':name\' updated.',
        'title'         => 'Menu Link :name',
    ],
    'fields'        => [
        'name' => 'Name',
        'entity' => 'Entity',
    ],
    'index'         => [
        'add'           => 'New Menu Link',
        'description'   => 'Manage the menu links of :name.',
        'header'        => 'Menu Link of :name',
        'title'         => 'Menu Links',
    ],
    'placeholders'  => [
        'entity'    => 'Choose an entity',
        'name'      => 'Name of the menu link',
    ],
    'show'          => [
        'description'   => 'A detailed view of a menu link',
        'tabs'          => [
            'information'   => 'Information',
        ],
        'title'         => 'Menu Link :name',
    ],
];
