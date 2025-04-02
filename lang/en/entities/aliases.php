<?php

return [
    'actions'       => [
        'add'   => 'Add an alias',
    ],
    'create'        => [
        'helper'    => 'Create an alias for :name, which will make it findable in the global search and through :code mentions.',
        'success'   => 'Alias :name added to :entity.',
        'title'     => 'New alias',
    ],
    'destroy'       => [
        'success'   => 'Alias :name removed.',
    ],
    'fields'        => [
        'name'  => 'Name',
    ],
    'helpers'       => [
        'primary'   => 'Setting one or several aliases on the entity will make it findable in the global search (top bar) and through :code mentions.',
    ],
    'pitch'         => 'Create aliases for this entity to easily find it through the search and through mentions.',
    'placeholders'  => [
        'name'  => 'New alias',
    ],
    'update'        => [
        'success'   => 'Alias :name updated for :entity.',
        'title'     => 'Update alias for :name',
    ],
];
