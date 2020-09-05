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
        'abbreviation'  => 'Abbreviation',
        'end_year'      => 'End Year',
        'start_year'    => 'Start Year',
    ],
    'helpers'       => [
        'eras'      => 'The timeline needs to be created before eras can be added to it.',
        'primary'   => 'Separate your timeline into eras. A timeline needs at least one era to properly work.',
    ],
    'placeholders'  => [
        'abbreviation'  => 'AD, BC, BCE',
        'end_year'      => 'Year the era ends. Leave blank if this is the current era.',
        'name'          => 'Modern Era, Bronz Age, Galactic Wars',
        'start_year'    => 'Year the era starts. Leave blank if this is the first era.',
    ],
    'reorder'       => [
        'success'   => 'Elements of the :era era reordered.',
    ],
];
