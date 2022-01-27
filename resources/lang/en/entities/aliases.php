<?php

return [
    'actions'       => [
        'add'   => 'Add an alias',
    ],
    'create'        => [
        'success'   => 'Alias :name added to :entity.',
        'title'     => 'Add an alias to :name',
    ],
    'destroy'       => [
        'success'   => 'Alias :name removed.',
    ],
    'fields'        => [
        'name'  => 'Name',
    ],
    'helpers'       => [
        'primary'   => 'Setting one or several aliases on the entity will make it findable in the global search (top bar) and through mentions.',
    ],
    'placeholders'  => [
        'name'  => 'New alias',
    ],
    'unboosted'     => [
        'text'  => 'Adding aliases to entities for searches and mentions are reserved to :boosted-campaigns.',
    ],
    'update'        => [
        'success'   => 'Alias :name updated for :entity.',
        'title'     => 'Update alias for :name',
    ],
];
