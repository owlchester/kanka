<?php

return [
    'create'        => [
        'title' => 'Nový predmet',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character' => 'Postava',
        'image'     => 'Obrázok',
        'location'  => 'Miesto',
        'name'      => 'Názov',
        'price'     => 'Cena',
        'size'      => 'Veľkosť',
        'type'      => 'Typ',
    ],
    'index'         => [
        'title' => 'Predmety',
    ],
    'inventories'   => [
        'title' => 'Objekty s predmetom :name',
    ],
    'placeholders'  => [
        'character' => 'Vyber postavu',
        'location'  => 'Vyber miesto',
        'name'      => 'Názov predmetu',
        'price'     => 'Cena predmetu',
        'size'      => 'veľkosť, váha, rozmery',
        'type'      => 'zbraň, elixír, artefakt',
    ],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Objekty',
        ],
    ],
];
