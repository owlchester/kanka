<?php

return [
    'actions'       => [
        'add'   => 'Dodaj alias',
    ],
    'create'        => [
        'helper'    => 'Tworzy alias dla :name, dzięki czemu będzie widoczny podczas globalnego wyszukiwania oraz poprzez wzmianki :code.',
        'success'   => 'Dodano alias :name do elementu :entity.',
        'title'     => 'Dodaj alias do :name',
    ],
    'destroy'       => [
        'success'   => 'Usunięto alias :name.',
    ],
    'fields'        => [
        'name'  => 'Nazwa',
    ],
    'helpers'       => [
        'primary'   => 'Wyposażenie elementu w jeden lub więcej aliasów pozwoli wyszukiwać go za pomocą globalnego wyszukiwania (górny pasek) oraz przez wzmianki.',
    ],
    'pitch'         => 'Możliwość nadawania elementom aliasów pozwala łatwo je wyszukiwać i tworzyć wzmianki.',
    'placeholders'  => [
        'name'  => 'Nowy alias',
    ],
    'unboosted'     => [],
    'update'        => [
        'success'   => 'Zmieniono alias :name elementu :entity.',
        'title'     => 'Zmień alias :name',
    ],
];
