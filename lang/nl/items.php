<?php

return [
    'create'        => [
        'title' => 'Nieuw Voorwerp',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character' => 'Personage',
        'image'     => 'Afbeelding',
        'location'  => 'Locatie',
        'name'      => 'Naam',
        'price'     => 'Prijs',
        'size'      => 'Grootte',
        'type'      => 'Type',
    ],
    'index'         => [
        'title' => 'Voorwerpen',
    ],
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
