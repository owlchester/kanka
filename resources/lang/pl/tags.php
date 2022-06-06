<?php

return [
    'children'      => [
        'actions'   => [
            'add'   => 'Dodaj nową etykietę',
        ],
        'create'    => [
            'success'   => 'Dodano do elementu etykietę :name.',
            'title'     => 'Dodaj etykietę do elementu :name',
        ],
        'title'     => 'Etykiety pochodne od :name',
    ],
    'create'        => [
        'title' => 'Nowa etykieta',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'children'  => 'Pochodne',
        'name'      => 'Nazwa',
        'tag'       => 'Etykieta źródłowa',
        'tags'      => 'Etykiety pochodne',
        'type'      => 'Rodzaj',
    ],
    'helpers'       => [
        'nested_parent' => 'Wyświetlono etykiety pochodzące od :parent.',
        'nested_without'=> 'Wyświetlono wszystkie etykiety nie posiadające źródła. Kliknij na rząd, by wyświetlić etykiety pochodne.',
        'no_children'   => 'Obecnie nie oznaczono tą etykietą żadnych elementów.',
    ],
    'hints'         => [
        'children'  => 'Na liście znajdują się wszystkie elementy posiadające tę etykietę i etykiety pochodne.',
        'tag'       => 'Na liście znajdują się wszystkie elementy posiadające tę etykietę.',
    ],
    'index'         => [
        'title' => 'Etykiety',
    ],
    'new_tag'       => 'Nowa etykieta',
    'placeholders'  => [
        'name'  => 'Nazwa etykiety',
        'tag'   => 'Wybierz etykietę źródłówą',
        'type'  => 'Wiedza tajemna, wojna, historia, religia, weksylologia',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Pochodne',
            'tags'      => 'Etykiety',
        ],
    ],
    'tags'          => [
        'title' => 'Etykiety pochodzące od :name',
    ],
];
