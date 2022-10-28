<?php

return [
    'create'        => [
        'title' => 'Nytt Föremål',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character' => 'Karaktär',
        'price'     => 'Pris',
        'size'      => 'Storlek',
    ],
    'index'         => [],
    'inventories'   => [
        'title' => 'Föremål :name Inventarier',
    ],
    'placeholders'  => [
        'name'  => 'Namn på föremålet',
        'price' => 'Pris på föremålet',
        'size'  => 'Storlek, Vikt, Dimensioner',
        'type'  => 'Vapen, Trolldryck, Artefakt',
    ],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Inventarier',
        ],
    ],
];
