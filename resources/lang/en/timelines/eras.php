<?php

return [
    'actions'       => [
        'add'   => 'Add a new era',
    ],
    'create'        => [
        'success'   => 'Era :name created.',
        'title'     => 'New Era',
    ],
    'delete'        => [
        'success'   => 'Era :name deleted.',
    ],
    'edit'          => [
        'success'   => 'Era :name updated.',
        'title'     => 'Edit Era :name',
    ],
    'fields'        => [
        'abbreviation' => 'Abbreviation',
        'start_year' => 'Start Year',
        'end_year' => 'End Year',
    ],
    'helpers'        => [
        'primary' => 'Separate your timeline into eras. A timeline needs at least one era to properly work.',
        'eras' => 'The timeline needs to be created before eras can be added to it.'
    ],
    'placeholders'  => [
        'name'      => 'Modern Era, Bronz Age, Galactic Wars',
        'start_year' => 'Year the era starts. Leave blank if this is the first era.',
        'end_year' => 'Year the era ends. Leave blank if this is the current era.',
        'abbreviation' => 'AD, BC, BCE',
    ],
];
