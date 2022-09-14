<?php

return [
    'create'        => [
        'title' => 'Nowy przedmiot',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character' => 'Postać',
        'image'     => 'Obraz',
        'item'      => 'Przedmiot źródłowy',
        'items'     => 'Przedmiot pochodny',
        'location'  => 'Miejsce',
        'name'      => 'Nazwa',
        'price'     => 'Cena',
        'size'      => 'Rozmiar',
        'type'      => 'Rodzaj',
    ],
    'helpers'       => [
        'nested_without'    => 'Wyświetla przedmioty nie posiadające źródła. Kliknij na rząd by zobaczyć przedmioty pochodne.',
    ],
    'hints'         => [
        'items' => 'Porządkuj przedmioty według źródeł',
    ],
    'index'         => [
        'title' => 'Przedmioty',
    ],
    'inventories'   => [
        'title' => 'Ekwipunki przedmiotu :name',
    ],
    'placeholders'  => [
        'name'  => 'Nazwa przedmiotu',
        'price' => 'Cena przedmiotu',
        'size'  => 'Wielkość, ciężar, wymiary',
        'type'  => 'Broń, eliksir, artefakt',
    ],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Ekwipunki',
        ],
    ],
];
