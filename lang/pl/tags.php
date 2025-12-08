<?php

return [
    'children'      => [
        'actions'   => [
            'add'           => 'Dodaj nową etykietę',
            'add_entity'    => 'Dodaj do elementu',
        ],
        'create'    => [
            'attach_success'        => '{1} Dodano etykietę :name :count elementowi.|[2,*] Dodano etykietę :name :count elementom.',
            'attach_success_entity' => 'Pomyślnie zmieniono etykiety :name.',
            'entity'                => 'Dodaj etykiety do :name',
            'helper'                => 'Oznacza jeden lub więcej elementów etykietą :name',
            'title'                 => 'Oznaczanie etykietą',
        ],
    ],
    'create'        => [
        'title' => 'Nowa etykieta',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'children'          => 'Pochodne',
        'is_auto_applied'   => 'Dodawaj automatycznie',
        'is_hidden'         => 'Ukryj w nagłówkach i dymkach',
    ],
    'helpers'       => [
        'no_children'   => 'Obecnie nie oznaczono tą etykietą żadnych elementów.',
        'no_posts'      => 'Obecnie nie oznaczono tą etykietą żadnych komentarzy.',
    ],
    'hints'         => [
        'children'          => 'Na liście znajdują się wszystkie elementy posiadające tę etykietę i etykiety pochodne.',
        'is_auto_applied'   => 'Zaznacz by dodawać tę etykietę automatycznie do nowych elementów.',
        'is_hidden'         => 'Po zaznaczeniu, ta etykieta nie będzie wyświetlana w nagłówku i dymkach elementu',
        'tag'               => 'Na liście znajdują się wszystkie elementy posiadające tę etykietę.',
    ],
    'index'         => [],
    'lists'         => [
        'empty' => 'Stosuj etykiety, by łączyć i grupować różne elementy, ułatwiając filtrowanie i nawigację.',
    ],
    'placeholders'  => [
        'type'  => 'Wiedza tajemna, wojna, historia, religia, weksylologia',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Pochodne',
        ],
    ],
    'tags'          => [],
    'transfer'      => [
        'entities'      => [
            'helper'    => 'Zmienia etykietę :name na inną u wszystkich elementów',
            'title'     => 'Zmiana etykiety elementów',
        ],
        'fail'          => 'Nie udało się zmienić elementom etykiety :tag na nową etykietę :newTag.',
        'fail_post'     => 'Nie udało się zmienić komentarzom etykiety :tag na nową etykietę :newTag.',
        'posts'         => [
            'helper'    => 'Zmienia etykietę :name na inną u wszystkich komentarzy',
            'title'     => 'Zmiana etykiety komentarzy',
        ],
        'success'       => 'Zamieniono elementom etykietę :tag na nową etykietę :newTag.',
        'success_post'  => 'Zamieniono komentarzom etykietę :tag na nową etykietę :newTag.',
        'transfer'      => 'Zamień',
    ],
];
