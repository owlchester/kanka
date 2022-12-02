<?php

return [
    'characters'    => [
        'helpers'   => [
            'all_characters'    => 'Wyświetla wszystkie postaci należące do tej rasy i ras pochodnych.',
            'characters'        => 'Wyświetla wyłącznie postaci należące do tej rasy.',
        ],
        'title'     => 'Postaci rasy :nazwa',
    ],
    'create'        => [
        'title' => 'Nowa rasa',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'characters'    => 'Postaci',
        'locations'     => 'Umiejscowienie',
        'race'          => 'Rasa źródłowa',
        'races'         => 'Rasy pochodne',
    ],
    'helpers'       => [
        'nested_without'    => 'Wyświetlono wszystkie rasy nieposiadające źródła. Kliknij na rząd, by wyświetlić rasy pochodne.',
    ],
    'index'         => [],
    'placeholders'  => [
        'name'  => 'Nazwa rasy',
        'type'  => 'Człowiek, sidhe, borg',
    ],
    'races'         => [
        'title' => 'Rasy pochodne od :name',
    ],
    'show'          => [
        'tabs'  => [
            'characters'    => 'Postaci',
            'races'         => 'Rasy pochodne',
        ],
    ],
];
