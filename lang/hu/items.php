<?php

return [
    'create'        => [
        'title' => 'Új tárgy',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character' => 'Karakter',
        'price'     => 'Ár',
        'size'      => 'Méret',
    ],
    'index'         => [],
    'inventories'   => [
        'title' => ':name tárgy Felszerelései',
    ],
    'placeholders'  => [
        'name'  => 'A tárgy neve',
        'price' => 'A tárgy ára',
        'size'  => 'Méret, Súly, Térfogat',
        'type'  => 'Fegyver, bájital, ereklye',
    ],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Felszerelések',
        ],
    ],
];
