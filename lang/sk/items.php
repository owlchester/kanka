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
    ],
    'helpers'       => [
        'nested_without'    => 'Zobrazujú sa všetky predmety bez nadradeného predmetu. Kliknutím na riadok sa zobrazia podradené predmety.',
    ],
    'hints'         => [
        'items' => 'Organizuj predmety pomocou nadradených predmetov.',
    ],
    'index'         => [],
    'inventories'   => [],
    'placeholders'  => [
        'price' => 'Cena predmetu',
        'size'  => 'veľkosť, váha, rozmery',
        'type'  => 'zbraň, elixír, artefakt',
    ],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Objekty',
        ],
    ],
];
