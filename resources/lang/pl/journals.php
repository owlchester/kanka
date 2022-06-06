<?php

return [
    'create'        => [
        'title' => 'Nowy dziennik',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'author'    => 'Autor',
        'date'      => 'Data',
        'image'     => 'Obraz',
        'journal'   => 'Dziennik źródłowy',
        'journals'  => 'Dzienniki pochodne',
        'name'      => 'Nazwa',
        'type'      => 'Rodzaj',
    ],
    'helpers'       => [
        'journals'      => 'Wyświetla wszystkie dzienniki pochodne, albo tylko pochodzące bezpośrednio od tego.',
        'nested_parent' => 'Wyświetlono dzienniki pochodzące od :parent.',
        'nested_without'=> 'Wyświetlono wszystkie dzienniki nie posiadające źródła. Kliknij na rząd, by wyświetlić dzienniki pochodne.',
    ],
    'index'         => [
        'title' => 'Dzienniki',
    ],
    'journals'      => [
        'title' => 'Dzienniki pochodne dziennika :name',
    ],
    'placeholders'  => [
        'author'    => 'Osoba, która napisała dziennik',
        'date'      => 'Data utworzenia dziennika (w prawdziwym świecie)',
        'journal'   => 'Wybierz dziennik źródłowy',
        'name'      => 'Nazwa dziennika',
        'type'      => 'Sesja, jednostrzał, szkic',
    ],
    'show'          => [
        'tabs'  => [
            'journals'  => 'Dzienniki',
        ],
    ],
];
