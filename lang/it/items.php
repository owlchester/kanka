<?php

return [
    'create'        => [
        'title' => 'Nuovo Oggetto',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character' => 'Personaggio',
        'price'     => 'Prezzo',
        'size'      => 'Taglia',
    ],
    'index'         => [],
    'inventories'   => [
        'title' => 'Inventari dell\'oggetto :name',
    ],
    'placeholders'  => [
        'name'  => 'Nome dell\'oggetto',
        'price' => 'Prezzo dell\'oggetto',
        'size'  => 'Taglia, Peso, Dimensioni',
        'type'  => 'Arma, Pozione, Artefatto',
    ],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Inventari',
        ],
    ],
];
