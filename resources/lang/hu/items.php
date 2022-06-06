<?php

return [
    'create'        => [
        'title' => 'Új tárgy',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character' => 'Karakter',
        'image'     => 'Kép',
        'location'  => 'Helyszín',
        'name'      => 'Név',
        'price'     => 'Ár',
        'size'      => 'Méret',
        'type'      => 'Típus',
    ],
    'index'         => [
        'title' => 'Tárgyak',
    ],
    'inventories'   => [
        'title' => ':name tárgy Felszerelései',
    ],
    'placeholders'  => [
        'character' => 'Válassz ki egy karaktert!',
        'location'  => 'Válassz ki egy helyszínt!',
        'name'      => 'A tárgy neve',
        'price'     => 'A tárgy ára',
        'size'      => 'Méret, Súly, Térfogat',
        'type'      => 'Fegyver, bájital, ereklye',
    ],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Felszerelések',
        ],
    ],
];
