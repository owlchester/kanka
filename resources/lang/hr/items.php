<?php

return [
    'create'        => [
        'title' => 'Novi predmet',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character' => 'Lik',
        'image'     => 'Slika',
        'location'  => 'Lokacija',
        'name'      => 'Naziv',
        'price'     => 'Cijena',
        'size'      => 'Veličina',
        'type'      => 'Tip',
    ],
    'index'         => [
        'title' => 'Predmeti',
    ],
    'inventories'   => [
        'title' => 'Inventar predmeta :name',
    ],
    'placeholders'  => [
        'name'  => 'Naziv predmeta',
        'price' => 'Cijena predmeta',
        'size'  => 'Veličina, težina, dimenzije',
        'type'  => 'Oružje, napitak, artefakt',
    ],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Informacije',
        ],
    ],
];
