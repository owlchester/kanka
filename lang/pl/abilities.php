<?php

return [
    'abilities'     => [
        'title' => 'Zdolności wywodzące się od :name',
    ],
    'children'      => [
        'actions'       => [
            'add'   => 'Dodaj zdolność do elementu',
        ],
        'create'        => [
            'success'   => 'Dodano elementowi zdolność :name',
            'title'     => 'Dodaj elementowi zdolność :name',
        ],
        'description'   => 'Elementy posiadające tę zdolność',
        'title'         => 'Elementy zdolności :name',
    ],
    'create'        => [
        'title' => 'Nowa zdolność',
    ],
    'destroy'       => [],
    'edit'          => [],
    'entities'      => [
        'title' => 'Elementy posiadające zdolność :name',
    ],
    'fields'        => [
        'abilities' => 'Zdolności pochodne',
        'ability'   => 'Zdolność źródłowa',
        'charges'   => 'Ładunki',
    ],
    'helpers'       => [
        'nested_without'    => 'Wyświetlono wszystkie zdolności nieposiadające źródła. Kliknij na rząd, by wyświetlić zdolności pochodne.',
    ],
    'index'         => [],
    'placeholders'  => [
        'charges'   => 'Liczba ładunków zdolności. Możesz wpisać wartość cechy jako {Level}*{CHA}',
        'name'      => 'Kula ognia, alarm, podstępny atak',
        'type'      => 'Czar, umiejętność, technika bojowa',
    ],
    'reorder'       => [
        'parentless'    => 'Bez źródła',
        'success'       => 'Zmieniono kolejność zdolności.',
        'title'         => 'Zmień kolejność zdolności',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Zdolności',
            'entities'  => 'Elementy',
            'reorder'   => 'Zmień kolejność',
        ],
    ],
];
