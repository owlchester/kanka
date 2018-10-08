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
        'description'   => 'Edit a menu item.',
        'success'       => 'Menu Link \':name\' updated.',
        'title'         => 'Menu Link :name',
    ],
    'fields'        => [
        'entity'    => 'Entity',
        'name'      => 'Name',
        'tab'       => 'Tab',
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
        'tab'       => 'history, relations, notes',
    ],
    'show'          => [
        'description'   => 'A detailed view of a menu link',
        'tabs'          => [
            'information'   => 'Information',
        ],
        'title'         => 'Menu Link :name',
    ],
];
