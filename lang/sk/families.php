<?php

return [
    'create'        => [
        'title' => 'Nový rod',
    ],
    'destroy'       => [],
    'edit'          => [],
    'families'      => [],
    'fields'        => [],
    'helpers'       => [],
    'hints'         => [
        'is_extinct'    => 'Tento rod vyhynul.',
        'members'       => 'Zoznam členov a členiek daného rodu sa zobrazuje na tomto mieste. Úpravou danej postavy je možné ju pridať do daného rodu v poli Rod.',
    ],
    'index'         => [],
    'members'       => [
        'create'    => [
            'success'   => '{0} Žiaden člen nebol pridaný.|{1} 1 člen bol pridaný.|[2,4] :count členovia boli pridaní.|[5,*] :count členov bolo pridaných.',
            'title'     => 'Noví členovia',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Názov rodu',
        'type'  => 'Kráľovský, Šľachtický, Vyhynutý',
    ],
    'show'          => [
        'tabs'  => [
            'tree'  => 'Rodokmeň',
        ],
    ],
];
