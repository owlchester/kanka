<?php

return [
    'characters'    => [
        'helpers'   => [
            'all_characters'    => 'Minden, az adott fajhoz és alfajaihoz tartozó karakter megmutatása',
            'characters'        => 'Minden karaktert megmutat, ami közvetlenük ehhez a fajhoz kapcsolódik.',
        ],
        'title'     => ':name fajú karakterek',
    ],
    'create'        => [
        'title' => 'Új faj',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'characters'    => 'Karakterek',
        'name'          => 'Név',
        'race'          => 'Szülő Faj',
        'races'         => 'Alfajok',
        'type'          => 'Típus',
    ],
    'helpers'       => [
        'nested_parent' => ':parent fajainak megmutatása.',
        'nested_without'=> 'Megmutat minden fajt, aminek nincs szülője. Klikkelj egy sorra, hogy megnézd a gyermekfajait.',
    ],
    'index'         => [
        'title' => 'Fajok',
    ],
    'placeholders'  => [
        'name'  => 'A faj neve',
        'type'  => 'Ember, tündér, Borg',
    ],
    'races'         => [
        'title' => ':name alfajai',
    ],
    'show'          => [
        'tabs'  => [
            'characters'    => 'Karakterek',
            'races'         => 'Alfajok',
        ],
    ],
];
