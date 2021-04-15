<?php

return [
    'characters'    => [
        'description'   => 'Characters belonging to the race.',
        'helpers'       => [
            'all_characters'    => 'Displaying all the characters related to this race and it\'s sub races.',
            'characters'        => 'Displaying all the characters directly related to this race.',
        ],
        'title'         => 'Race :name Characters',
    ],
    'create'        => [
        'description'   => 'Create a new race',
        'success'       => 'Race \':name\' created.',
        'title'         => 'New Race',
    ],
    'destroy'       => [
        'success'   => 'Race \':name\' removed.',
    ],
    'edit'          => [
        'success'   => 'Race \':name\' updated.',
        'title'     => 'Edit Race :name',
    ],
    'fields'        => [
        'characters'    => 'Characters',
        'name'          => 'Name',
        'race'          => 'Parent Race',
        'races'         => 'Sub Races',
        'type'          => 'Type',
    ],
    'helpers'       => [
        'nested_parent' => 'Displaying the races of :parent.',
        'nested_without'=> 'Displaying all races that don\'t have a parent race. Click on a row to see the children races.',
    ],
    'index'         => [
        'add'           => 'New Race',
        'description'   => 'Manage the races of :name.',
        'header'        => 'Races of :name',
        'title'         => 'Races',
    ],
    'placeholders'  => [
        'name'  => 'Name of the race',
        'type'  => 'Human, Fey, Borg',
    ],
    'races'         => [
        'description'   => 'Races belonging to the race.',
        'title'         => 'Race :name Subraces',
    ],
    'show'          => [
        'description'   => 'A detailed view of a race',
        'tabs'          => [
            'characters'    => 'Characters',
            'menu'          => 'Menu',
            'races'         => 'Subraces',
        ],
        'title'         => 'Race :name',
    ],
];
