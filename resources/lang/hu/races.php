<?php

return [
    'characters'    => [
        'description'   => 'Ehhez a fajhoz tartozó karakterek.',
        'title'         => ':name fajú karakterek',
    ],
    'create'        => [
        'description'   => 'Új faj létrehozása',
        'success'       => 'A \':name\' fajt létrehoztuk.',
        'title'         => 'Új faj',
    ],
    'destroy'       => [
        'success'   => 'A \':name\' fajt eltávolítottuk.',
    ],
    'edit'          => [
        'success'   => 'A \':name\' fajt frissítettük.',
        'title'     => ':name faj szerkesztése',
    ],
    'fields'        => [
        'characters'    => 'Karakterek',
        'name'          => 'Név',
        'race'          => 'Szülő Faj',
        'races'         => 'Alfajok',
        'type'          => 'Típus',
    ],
    'helpers'       => [
        'nested'    => 'Hierarchikus nézetben a fajaidat alá-fölérendeltségi rendszerben láthatod. Alapértelemzetten azok a fajok látszanak, melyek nem alfajai egy másiknak sem. Egy fajra kattintva láthatod annak alfajait, melyek, amennyiben vannak saját alfajaik is, szintén kattinthatóak lesznek.',
    ],
    'index'         => [
        'add'           => 'Új faj',
        'description'   => ':name fajainak kezelése',
        'header'        => ':name fajai',
        'title'         => 'Fajok',
    ],
    'placeholders'  => [
        'name'  => 'A faj neve',
        'type'  => 'Ember, tündér, Borg',
    ],
    'races'         => [
        'description'   => 'A fajhoz tartozó alfajok',
        'title'         => ':name alfajai',
    ],
    'show'          => [
        'description'   => 'Egy faj részletes nézete',
        'tabs'          => [
            'characters'    => 'Karakterek',
            'menu'          => 'Menü',
            'races'         => 'Alfajok',
        ],
        'title'         => ':name faj',
    ],
];
