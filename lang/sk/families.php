<?php

return [
    'create'        => [
        'title' => 'Nový rod',
    ],
    'destroy'       => [],
    'edit'          => [],
    'families'      => [],
    'fields'        => [
        'members'   => 'Členovia',
    ],
    'helpers'       => [],
    'hints'         => [
        'members'   => 'Zoznam členov a členiek daného rodu sa zobrazuje na tomto mieste. Úpravou danej postavy je možné ju pridať do daného rodu v poli Rod.',
    ],
    'index'         => [],
    'members'       => [
        'create'    => [
            'submit'    => 'Pridať členov',
            'success'   => '{0} Žiaden člen nebol pridaný.|{1} 1 člen bol pridaný.|[2,4] :count členovia boli pridaní.|[5,*] :count členov bolo pridaných.',
            'title'     => 'Noví členovia',
        ],
        'helpers'   => [
            'all_members'       => 'Nasledujúci zoznam zobrazuje všetky postavy, ktoré sú súčasťou tohto alebo podradeného rodu.',
            'direct_members'    => 'Väčšina rodov má členov/ky, ktorí/é ich vedú alebo ich urobili slávnymi. Nasledujúci zoznam zobrazuje postavy, ktoré sú priamymi členmi/kami rodu.',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Názov rodu',
        'type'  => 'Kráľovský, Šľachtický, Vyhynutý',
    ],
    'show'          => [
        'tabs'  => [
            'members'   => 'Členovia/ky',
            'tree'      => 'Rodokmeň',
        ],
    ],
];
