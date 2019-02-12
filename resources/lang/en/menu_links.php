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
        'menu'      => 'Menu',
        'type'     => 'Entity Type',
        'filters'    => 'Filters',
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
        'menu'      => 'Menu subpage (use the last text of the url)',
        'tab'       => 'entry, relations, notes',
        'filters'   => 'location_id=15&type=city'
    ],
    'show'          => [
        'description'   => 'A detailed view of a menu link',
        'tabs'          => [
            'information'   => 'Information',
        ],
        'title'         => 'Menu Link :name',
    ],
];
