<?php

return [
    'create'        => [
        'title' => 'Nowa rodzina',
    ],
    'destroy'       => [],
    'edit'          => [],
    'families'      => [],
    'fields'        => [
        'members'   => 'Członkowie',
    ],
    'helpers'       => [
        'descendants'       => 'Na liście znajdują się wszystkie rodziny wywodzące się od tej rodziny, nie tylko bezpośrednio.',
        'nested_without'    => 'Wyświetlono wszystkie rodziny nieposiadające źródła. Kliknij na rząd, by wyświetlić rodziny pochodne.',
    ],
    'hints'         => [
        'members'   => 'Lista członków rodziny. Aby dodać postać do rodziny, wybierz ją z listy w pozycji "Rodzina" podczas edycji tej postaci.',
    ],
    'index'         => [],
    'members'       => [
        'helpers'   => [
            'all_members'       => 'Na liście znajdują się postaci należące do tej rodziny i wszystkich jej rodzin pochodnych.',
            'direct_members'    => 'Większość rodzin posiada członków, którymi słynie. Na poniższej liście znajdują się postaci należące do tej rodziny bezpośrednio.',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Nazwisko rodowe',
        'type'  => 'Królewska, szlachecka, wymarła',
    ],
    'show'          => [
        'tabs'  => [
            'members'   => 'Członkowie',
            'tree'      => 'Drzewo genealogiczne',
        ],
    ],
];
