<?php

return [
    'create'        => [
        'title' => 'Novi predmet',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'price' => 'Cijena',
        'size'  => 'Veličina',
    ],
    'index'         => [],
    'inventories'   => [],
    'placeholders'  => [
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
