<?php

return [
    'actions'       => [
        'add'   => 'Add a new era',
    ],
    'bulks'         => [
        'delete'    => '{0} Removed :count era.|{1} Removed :count era.|[2,*] Removed :count eras.',
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
        'is_collapsed'  => 'Collapsed',
        'start_year'    => 'Start Year',
    ],
    'helpers'       => [
        'eras'          => 'The timeline needs to be created before eras can be added to it.',
        'is_collapsed'  => 'Era is collapsed (minimised) by default.',
        'primary'       => 'Separate your timeline into eras. A timeline needs at least one era to properly work.',
    ],
    'index'         => [
        'title' => 'Eras of :name',
    ],
    'placeholders'  => [
        'abbreviation'  => 'AD, BC, BCE',
        'end_year'      => 'Year the era ends. Leave blank if this is the current era.',
        'name'          => 'Modern Era, Bronze Age, Galactic Wars',
        'start_year'    => 'Year the era starts. Leave blank if this is the first era.',
    ],
];
