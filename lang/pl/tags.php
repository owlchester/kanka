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
        'children'          => 'Pochodne',
        'is_auto_applied'   => 'Dodawaj automatycznie',
        'tag'               => 'Etykieta źródłowa',
        'tags'              => 'Etykiety pochodne',
    ],
    'helpers'       => [
        'nested_without'    => 'Wyświetlono wszystkie etykiety nie posiadające źródła. Kliknij na rząd, by wyświetlić etykiety pochodne.',
        'no_children'       => 'Obecnie nie oznaczono tą etykietą żadnych elementów.',
    ],
    'hints'         => [
        'children'          => 'Na liście znajdują się wszystkie elementy posiadające tę etykietę i etykiety pochodne.',
        'is_auto_applied'   => 'Zaznacz by dodawać tę etykietę automatycznie do nowych elementów.',
        'tag'               => 'Na liście znajdują się wszystkie elementy posiadające tę etykietę.',
    ],
    'index'         => [],
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
