<?php

return [
    'create'        => [
        'description'   => 'Vytvoriť nový rod',
        'success'       => 'Rod :name vytvorený.',
        'title'         => 'Nový rod',
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
        'families'  => 'Následovnícke rody',
        'family'    => 'Rodičovský rod',
        'image'     => 'Obrázok',
        'location'  => 'Miesto',
        'members'   => 'Členovia',
        'name'      => 'Názov',
        'relation'  => 'Vzťah',
        'type'      => 'Typ',
    ],
    'helpers'       => [
        'descendants'   => 'Tento zoznam obsahuje všetky rody, ktoré sú potomkami tohto rodu a nielen tých, ktoré sp priamymi potomkami.',
        'nested'        => 'Vo vnorenom zobrazení vieš zoradiť tvoje rody podľa rodičovských rodov. Rody bez nadradeného rodu sa zoradia štandardným spôsobom. Rody s následovnickými rodmi je možné rozkliknúť, dokiaľ nebudú existovať už nižšie následovnícke rody.',
    ],
    'hints'         => [
        'members'   => 'Zoznam členov a členiek daného rodu sa zobrazuje na tomto mieste. Úpravou danej postavy je možné ju pridať do daného rodu v poli Rod.',
    ],
    'index'         => [
        'add'           => 'Nový rod',
        'description'   => 'Spravovať rody :name.',
        'header'        => 'Rody :name',
        'title'         => 'Rody',
    ],
    'members'       => [
        'helpers'   => [
            'all_members'       => 'Nasledujúci zoznam zobrazuje všetky postavy, ktoré sú súčasťou tohto alebo následovníckeho rodu.',
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
        'description'   => 'Detailné zobrazenie rodu',
        'tabs'          => [
            'all_members'   => 'Všetci členovia/ky',
            'families'      => 'Rody',
            'members'       => 'Členovia/ky',
            'relation'      => 'Vzťahy',
        ],
        'title'         => 'Rod :name',
    ],
];
