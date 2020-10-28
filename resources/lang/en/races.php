<?php

return [
    'characters'    => [
        'description'   => 'Characters belonging to the race.',
        'title'         => 'Race :name Characters',
        'helpers' => [
            'characters' => 'Displaying all the characters directly related to this race.',
            'all_characters' => 'Displaying all the characters related to this race and it\'s sub races.',
        ]
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
        'nested'    => 'When in Nested View, you can view your Races in a nested manner. Races with no parent race will be shown by default. Races with sub races can be clicked to view those children. You can keep clicking until there are no more children to view.',
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
