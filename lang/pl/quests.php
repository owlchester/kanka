<?php

return [
    'create'        => [
        'title' => 'Nowa misja',
    ],
    'destroy'       => [],
    'edit'          => [],
    'elements'      => [
        'create'    => [
            'success'   => 'Nowy element misji :name',
            'title'     => 'Nowy element misji :name',
        ],
        'destroy'   => [
            'success'   => 'Usunięto element misji :entity.',
        ],
        'edit'      => [
            'success'   => 'Zmieniono element misji :entity.',
            'title'     => 'Zmień element misji :name',
        ],
        'fields'    => [
            'description'       => 'Szczegóły',
            'entity_or_name'    => 'Wybierz inny element kampanii albo nadaj nazwę temu elementowi.',
            'name'              => 'Nazwa',
            'quest'             => 'Misja',
        ],
        'title'     => 'Elementy misji :name',
    ],
    'fields'        => [
        'character'     => 'Donator',
        'copy_elements' => 'Kopiuj elementy związane z misją',
        'date'          => 'Data',
        'is_completed'  => 'Ukończona',
        'quest'         => 'Misja źródłowa',
        'quests'        => 'Misje pochodne',
        'role'          => 'Rola',
    ],
    'helpers'       => [
        'is_completed'      => 'Wybierz, jeżeli misję można uznać za ukończoną.',
        'nested_without'    => 'Wyświetlono wszystkie misje nie posiadające źródła. Kliknij na rząd, by wyświetlić misje pochodne.',
    ],
    'hints'         => [
        'quests'    => 'Przy użyciu pola Misji źródłowej można stworzyć sieć zazębiających się misji.',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'  => 'Data misji w prawdziwym świecie',
        'name'  => 'Nazwa misji',
        'quest' => 'Misja źródłowa',
        'role'  => 'Rola elementu w tej misji',
        'type'  => 'Wątek osobisty, misja poboczna, misja główna',
    ],
    'show'          => [
        'actions'   => [
            'add_element'   => 'Dodaj element',
        ],
        'tabs'      => [
            'elements'  => 'Elementy',
        ],
    ],
];
