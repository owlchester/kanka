<?php

return [
    'create'        => [
        'description'   => '',
        'success'       => 'Family \':name\' created.',
        'title'         => 'Create a new family',
    ],
    'destroy'       => [
        'success'   => 'Family \':name\' removed.',
    ],
    'edit'          => [
        'description'   => '',
        'success'       => 'Family \':name\' updated.',
        'title'         => 'Edit Family :name',
    ],
    'fields'        => [
        'history'   => 'History',
        'image'     => 'Image',
        'location'  => 'Location',
        'members'   => 'Members',
        'name'      => 'Name',
        'relation'  => 'Relation',
    ],
    'index'         => [
        'add'           => 'New Family',
        'description'   => 'Manage the families of :name.',
        'header'        => 'Families of :name',
        'title'         => 'Families',
    ],
    'placeholders'  => [
        'location'  => 'Choose a location',
        'name'      => 'Name of the family',
    ],
    'show'          => [
        'description'   => 'A detailed view of a family',
        'tabs'          => [
            'history'   => 'History',
            'member'    => 'Members',
            'relation'  => 'Relations',
        ],
        'title'         => 'Family :name',
    ],
];
