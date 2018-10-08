<?php

return [
    'create'        => [
        'description'   => 'Create a new family',
        'success'       => 'Family \':name\' created.',
        'title'         => 'New Family',
    ],
    'destroy'       => [
        'success'   => 'Family \':name\' removed.',
    ],
    'edit'          => [
        'success'   => 'Family \':name\' updated.',
        'title'     => 'Edit Family :name',
    ],
    'fields'        => [
        'history'   => 'History',
        'image'     => 'Image',
        'location'  => 'Location',
        'members'   => 'Members',
        'name'      => 'Name',
        'relation'  => 'Relation',
    ],
    'hints'         => [
        'members'   => 'Members of a family are listed here. A character can be added to a family by editing the desired character and using the "Family" dropdown.',
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
