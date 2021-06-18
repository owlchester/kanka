<?php

return [
    'actions'       => [
        'add'       => 'New Entity Note',
        'add_user'  => 'Add user',
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
        'collapsed' => 'Collapse entity note by default',
        'creator'   => 'Creator',
        'entry'     => 'Entry',
        'name'      => 'Name',
    ],
    'hint'          => 'Information that doesn\'t quite fit in the standard fields of an entity or that should be kept private can be added as Entity Notes.',
    'hints'         => [],
    'index'         => [
        'title' => 'Entity Notes for :name',
    ],
    'placeholders'  => [
        'name'  => 'Name of the entity note, observation or remark',
    ],
    'show'          => [
        'advanced'  => 'Advanced Permissions',
        'title'     => 'Entity Note :name for :entity',
    ],
];
