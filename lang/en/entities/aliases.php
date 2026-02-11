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
        'primary'   => 'Setting one or several aliases on the entry will make it findable in the global search (top bar) and through :code mentions.',
    ],
    'limit'         => 'The campaign has reached the limit of aliases available to it. To get unlimited aliases, unlock premium features.',
    'pitch'         => 'Add aliases to this entry to make it easier to find in search and when using mentions. Perfect for nicknames, titles, or alternate spellings.',
    'placeholders'  => [
        'name'  => 'New alias',
    ],
    'update'        => [
        'success'   => 'Alias :name updated for :entity.',
        'title'     => 'Update alias for :name',
    ],
];
