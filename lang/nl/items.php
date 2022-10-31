<?php

return [
    'create'        => [
        'title' => 'Nieuw Voorwerp',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character' => 'Personage',
        'price'     => 'Prijs',
        'size'      => 'Grootte',
    ],
    'index'         => [],
    'inventories'   => [
        'title' => 'Voorwerp :name Inventories',
    ],
    'placeholders'  => [
        'name'  => 'Naam van het voorwerp',
        'price' => 'Prijs van het voorwerp',
        'size'  => 'Grootte, Gewicht, Afmeting',
        'type'  => 'Wapen, Potion, Artefact',
    ],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Inventories',
        ],
    ],
];
