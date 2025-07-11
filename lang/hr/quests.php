<?php

return [
    'create'        => [
        'title' => 'Novi zadatak',
    ],
    'destroy'       => [],
    'edit'          => [],
    'elements'      => [
        'create'    => [
            'success'   => 'Entitet :entity dodan na zadatak.',
            'title'     => 'Novi element za :name',
        ],
        'destroy'   => [
            'success'   => 'Element zadatka :entity uklonjen.',
        ],
        'edit'      => [
            'success'   => 'Element zadatka :entity ažuriran.',
            'title'     => 'Ažuriran element zadatka za :name',
        ],
        'fields'    => [
            'description'   => 'Opis',
        ],
    ],
    'fields'        => [
        'copy_elements' => 'Kopirajte elemente pridružene zadatku',
        'date'          => 'Datum',
        'is_completed'  => 'Izvršen',
        'role'          => 'Uloga',
    ],
    'helpers'       => [],
    'hints'         => [],
    'index'         => [],
    'placeholders'  => [
        'date'  => 'Stvarni datum zadatka',
        'role'  => 'Uloga ovog entieta u zadatku',
        'type'  => 'Priča o liku, Sporedni zadatak, Glavni zadatak',
    ],
    'show'          => [
        'actions'   => [
            'add_element'   => 'Dodaj element',
        ],
        'tabs'      => [
            'elements'  => 'Elementi',
        ],
    ],
];
