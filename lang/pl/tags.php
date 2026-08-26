<?php

return [
    'children'      => [
        'actions'   => [
            'add'           => 'Dodaj do etykiety',
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
        'icon'              => 'Ikona',
        'is_auto_applied'   => 'Dodawaj automatycznie',
        'is_hidden'         => 'Ukryj w nagłówkach i dymkach',
    ],
    'helpers'       => [
        'icon'          => 'Użyj ikony z :fontawesome lub :rpgawesome. Będzie wyświetlana zamiast nazwy etykiety na listach.',
        'no_children'   => 'Brak elementów oznaczonych tą etykietą.',
        'no_posts'      => 'Brak komentarzy oznaczonych tą etykietą.',
    ],
    'hints'         => [
        'children'          => 'Na liście znajdują się wszystkie elementy oznaczone tą etykietę i jej pochodnymi.',
        'is_auto_applied'   => 'Automatycznie oznaczaj nowo stworzone elementy tą etykietą.',
        'is_hidden'         => 'Nie wyświetlaj etykiety w dymkach i nagłówkach elementów.',
        'tag'               => 'Na liście znajdują się wszystkie etykiety pochodne od tej, oraz pochodne od jej pochodnych.',
    ],
    'index'         => [],
    'lists'         => [
        'empty' => 'Etykiety pozwalają grupować i filtrować elementy świata, ułatwiając nawigację.',
    ],
    'placeholders'  => [
        'icon'  => 'Spróbuj :example1 lub :example2',
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
