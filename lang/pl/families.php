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
    'helpers'       => [],
    'hints'         => [
        'is_extinct'    => 'Ta rodzina wymarła.',
        'members'       => 'Lista członków rodziny. Aby dodać postać do rodziny, wybierz ją z listy w pozycji "Rodzina" podczas edycji tej postaci.',
    ],
    'index'         => [],
    'members'       => [
        'create'    => [
            'submit'    => 'Dodaj członków',
            'success'   => '{0} Nie dodano członków.|{1} Dodano 1 członka.|[2,*] Dodano :count członków.',
            'title'     => 'Nowi członkowie',
        ],
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
