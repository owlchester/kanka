<?php

return [
    'create'        => [
        'title' => 'Nový predmet',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character' => 'Postava',
        'item'      => 'Nadradený predmet',
        'items'     => 'Podradený predmet',
        'price'     => 'Cena',
        'size'      => 'Veľkosť',
    ],
    'helpers'       => [
        'nested_without'    => 'Zobrazujú sa všetky predmety bez nadradeného predmetu. Kliknutím na riadok sa zobrazia podradené predmety.',
    ],
    'hints'         => [
        'items' => 'Organizuj predmety pomocou nadradených predmetov.',
    ],
    'index'         => [],
    'inventories'   => [
        'title' => 'Objekty s predmetom :name',
    ],
    'placeholders'  => [
        'name'  => 'Názov predmetu',
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
