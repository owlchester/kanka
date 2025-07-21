<?php

return [
    'create'        => [
        'title' => 'Nowa rodzina',
    ],
    'destroy'       => [],
    'edit'          => [],
    'families'      => [],
    'fields'        => [],
    'helpers'       => [],
    'hints'         => [
        'is_extinct'    => 'Ta rodzina wymarła.',
        'members'       => 'Lista członków rodziny. Aby dodać postać do rodziny, wybierz ją z listy w pozycji "Rodzina" podczas edycji tej postaci.',
    ],
    'index'         => [],
    'members'       => [
        'create'    => [
            'success'   => '{0} Nie dodano członków.|{1} Dodano 1 członka.|[2,*] Dodano :count członków.',
            'title'     => 'Nowi członkowie',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Nazwisko rodowe',
        'type'  => 'Królewska, szlachecka, wymarła',
    ],
    'show'          => [
        'tabs'  => [
            'tree'  => 'Drzewo genealogiczne',
        ],
    ],
];
