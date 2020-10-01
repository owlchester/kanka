<?php

return [
    'actions'       => [
        'add'   => 'New Entity Note',
    ],
    'create'        => [
        'description'   => 'Create a new Entity Note',
        'success'       => 'Entity Note \':name\' added to :entity.',
        'title'         => 'New Entity Note for :name',
    ],
    'destroy'       => [
        'success'   => 'Entity Note \':name\' for :entity removed.',
    ],
    'edit'          => [
        'description'   => 'Update an existing entity note',
        'success'       => 'Entity Note \':name\' for :entity updated.',
        'title'         => 'Update entity note for :name',
    ],
    'fields'        => [
        'creator'   => 'Creator',
        'entry'     => 'Entry',
        'name'      => 'Name',
    ],
    'hint'          => 'Information that doesn\'t quite fit in the standard fields of an entity or that should be kept private can be added as Entity Notes.',
    'index'         => [
        'title' => 'Entity Notes for :name',
    ],
    'placeholders'  => [
        'name'  => 'Name of the entity note, observation or remark',
    ],
    'show'          => [
        'title' => 'Entity Note :name for :entity',
    ],
];
