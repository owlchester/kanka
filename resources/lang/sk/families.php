<?php

return [
    'create'        => [
        'success'   => 'Rod :name vytvorený.',
        'title'     => 'Nový rod',
    ],
    'destroy'       => [
        'success'   => 'Rod :name odstránený.',
    ],
    'edit'          => [
        'success'   => 'Rod :name upravený.',
        'title'     => 'Upraviť rod :name',
    ],
    'families'      => [
        'title' => 'Rody rodu :name',
    ],
    'fields'        => [
        'families'  => 'Podradené rody',
        'family'    => 'Nadradený rod',
        'image'     => 'Obrázok',
        'location'  => 'Miesto',
        'members'   => 'Členovia',
        'name'      => 'Názov',
        'relation'  => 'Vzťah',
        'type'      => 'Typ',
    ],
    'helpers'       => [
        'descendants'   => 'Tento zoznam obsahuje všetky rody, ktoré sú potomkami tohto rodu a nielen tých, ktoré sp priamymi potomkami.',
        'nested_parent' => 'Zobraziť rody :parent.',
        'nested_without'=> 'Zobraziť všetky rody, ktoré nemajú nadradený rod. Kliknutím na riadok zobrazíš podradené rody.',
    ],
    'hints'         => [
        'members'   => 'Zoznam členov a členiek daného rodu sa zobrazuje na tomto mieste. Úpravou danej postavy je možné ju pridať do daného rodu v poli Rod.',
    ],
    'index'         => [
        'add'       => 'Nový rod',
        'header'    => 'Rody :name',
        'title'     => 'Rody',
    ],
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
            'relation'      => 'Vzťahy',
        ],
        'title' => 'Rod :name',
    ],
];
