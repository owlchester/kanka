<?php

return [
    'create'        => [
        'title' => 'Nový predmet',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character'     => 'Postava',
        'is_equipped'   => 'Vo vybavení',
        'price'         => 'Cena',
        'size'          => 'Veľkosť',
        'weight'        => 'Váha',
    ],
    'helpers'       => [],
    'hints'         => [],
    'index'         => [],
    'inventories'   => [],
    'placeholders'  => [
        'price' => 'Cena predmetu',
        'size'  => 'veľkosť, váha, rozmery',
        'type'  => 'zbraň, elixír, artefakt',
        'weight'=> 'Váha predmetu',
    ],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Objekty',
        ],
    ],
];
