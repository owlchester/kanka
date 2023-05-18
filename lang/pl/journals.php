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
    ],
    'helpers'       => [
        'journals'          => 'Wyświetla wszystkie dzienniki pochodne, albo tylko pochodzące bezpośrednio od tego.',
        'nested_without'    => 'Wyświetlono wszystkie dzienniki nieposiadające źródła. Kliknij na rząd, by wyświetlić dzienniki pochodne.',
    ],
    'index'         => [],
    'journals'      => [],
    'placeholders'  => [
        'author'    => 'Osoba, która napisała dziennik',
        'date'      => 'Data utworzenia dziennika (w prawdziwym świecie)',
        'type'      => 'Sesja, jednostrzał, szkic',
    ],
    'show'          => [],
];
