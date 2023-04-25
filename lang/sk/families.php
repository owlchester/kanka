<?php

return [
    'create'        => [
        'title' => 'Nový rod',
    ],
    'destroy'       => [],
    'edit'          => [],
    'families'      => [
        'title' => 'Rody rodu :name',
    ],
    'fields'        => [
        'families'  => 'Podradené rody',
        'family'    => 'Nadradený rod',
        'members'   => 'Členovia',
    ],
    'helpers'       => [
        'descendants'       => 'Tento zoznam obsahuje všetky rody, ktoré sú potomkami tohto rodu a nielen tých, ktoré sp priamymi potomkami.',
        'nested_without'    => 'Zobraziť všetky rody, ktoré nemajú nadradený rod. Kliknutím na riadok zobrazíš podradené rody.',
    ],
    'hints'         => [
        'members'   => 'Zoznam členov a členiek daného rodu sa zobrazuje na tomto mieste. Úpravou danej postavy je možné ju pridať do daného rodu v poli Rod.',
    ],
    'index'         => [],
    'members'       => [
        'helpers'   => [
            'all_members'       => 'Nasledujúci zoznam zobrazuje všetky postavy, ktoré sú súčasťou tohto alebo podradeného rodu.',
            'direct_members'    => 'Väčšina rodov má členov/ky, ktorí/é ich vedú alebo ich urobili slávnymi. Nasledujúci zoznam zobrazuje postavy, ktoré sú priamymi členmi/kami rodu.',
        ],
        'title'     => 'Členovia/ky rodu :name',
    ],
    'placeholders'  => [
        'location'  => 'Vybrať miesto',
        'name'      => 'Názov rodu',
        'type'      => 'Kráľovský, Šľachtický, Vyhynutý',
    ],
    'show'          => [
        'tabs'  => [
            'all_members'   => 'Všetci členovia/ky',
            'families'      => 'Rody',
            'members'       => 'Členovia/ky',
            'tree'          => 'Rodokmeň',
        ],
    ],
];
