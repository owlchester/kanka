<?php

return [
    'actions'       => [
        'add_element'   => 'Dodaj do epoki :era',
        'back'          => 'Powrót do :name',
        'edit'          => 'Edytuj historię',
        'save_order'    => 'Zapisz nową kolejność',
    ],
    'create'        => [
        'title' => 'Nowa historia',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'copy_elements' => 'Kopiuj składowe',
        'copy_eras'     => 'Kopiuj epoki',
        'eras'          => 'Epoki',
        'name'          => 'Nazwa',
        'reverse_order' => 'Odwróć kolejność epok',
        'timeline'      => 'Historia źródłowa',
        'timelines'     => 'Historie pochodne',
        'type'          => 'Rodzaj',
    ],
    'helpers'       => [
        'nested_without'    => 'Wyświetlono wszystkie historie nie posiadające źródła. Kliknij na rząd, by wyświetlić historie pochodne.',
        'no_era'            => 'Ta historia nie ma obecnie żadnych epok. Możesz je dodać na ekranie edycji, a potem uzupełnić tutaj o kolejne elementy.',
        'reverse_order'     => 'Zaznacz by wyświetlać epoki w odwróconym porządku chronologicznym (od najdawniejszej)',
    ],
    'index'         => [
        'title' => 'Historie',
    ],
    'placeholders'  => [
        'name'  => 'Nazwa historii',
        'type'  => 'Główna, kronika dziejów świata, historia królestwa',
    ],
    'show'          => [
        'tabs'  => [
            'timelines' => 'Historie',
        ],
    ],
    'timelines'     => [
        'title' => 'Historie historii :name',
    ],
];
