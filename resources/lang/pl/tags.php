<?php

return [
    'children'      => [
        'actions'       => [
            'add'   => 'Dodaj nową etykietę',
        ],
        'create'        => [
            'title' => 'Dodaj etykietę do elementu :name',
        ],
        'description'   => 'Elementy posiadające etykietę',
        'title'         => 'Etykiety pochodne od :name',
    ],
    'create'        => [
        'description'   => 'Stwórz nową etykietę',
        'success'       => 'Stworzono etykietę \':name\'.',
        'title'         => 'Nowa etykieta',
    ],
    'destroy'       => [
        'success'   => 'Usunięto etykietę \':name\'.',
    ],
    'edit'          => [
        'success'   => 'Zmieniono etykietę \':name\'.',
        'title'     => 'Edycja etykiety :name',
    ],
    'fields'        => [
        'characters'    => 'Postaci',
        'children'      => 'Pochodne',
        'name'          => 'Nazwa',
        'tag'           => 'Etykieta źródłowa',
        'tags'          => 'Etykiety pochodne',
        'type'          => 'Rodzaj',
    ],
    'helpers'       => [
        'nested'    => 'W widoku hierarchii najpierw wyświetlane są etykiety, które nie mają źródła. Po kliknięciu na wiersz etykiety zobaczysz jej pochodne. Możesz schodzić niżej, póki nie skończą się poziomy hierarchii.',
    ],
    'hints'         => [
        'children'  => 'Na liście znajdują się wszystkie elementy posiadające tę etykietę i etykiety pochodne.',
        'tag'       => 'Na liście znajdują się wszystkie elementy posiadające tę etykietę.',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Widok hierarchii',
        ],
        'add'           => 'Nowa etykieta',
        'description'   => 'Zarządzaj etykietami elementu :name.',
        'header'        => 'Etykiety w :name',
        'title'         => 'Etykiety',
    ],
    'new_tag'       => 'Nowa etykieta',
    'placeholders'  => [
        'name'  => 'Nazwa etykiety',
        'tag'   => 'Wybierz etykietę źródłówą',
        'type'  => 'Wiedza tajemna, wojna, historia, religia, weksylologia',
    ],
    'show'          => [
        'description'   => 'Szczegółowy widok etykiety',
        'tabs'          => [
            'children'      => 'Pochodne',
            'information'   => 'Informacje',
            'tags'          => 'Etykiety',
        ],
        'title'         => 'Etykieta :nazwa',
    ],
    'tags'          => [
        'description'   => 'Etykiety pochodne',
        'title'         => 'Etykiety pochodzące od :name',
    ],
];
