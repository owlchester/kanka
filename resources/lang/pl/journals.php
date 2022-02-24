<?php

return [
    'create'        => [
        'success'       => 'Stworzono dziennik \':name\'.',
        'title'         => 'Nowy dziennik',
    ],
    'destroy'       => [
        'success'   => 'Usunięto dziennik \':name\'.',
    ],
    'edit'          => [
        'success'   => 'Zaktualizowano dziennik \':name\'.',
        'title'     => 'Edycja dziennika :name',
    ],
    'fields'        => [
        'author'    => 'Autor',
        'date'      => 'Data',
        'image'     => 'Obraz',
        'journal'   => 'Dziennik źródłowy',
        'journals'  => 'Dzienniki pochodne',
        'name'      => 'Nazwa',
        'relation'  => 'Relacja',
        'type'      => 'Rodzaj',
    ],
    'helpers'       => [
        'journals'      => 'Wyświetla wszystkie dzienniki pochodne, albo tylko pochodzące bezpośrednio od tego.',
        'nested'        => 'W widoku hierarchii najpierw wyświetlane są dzienniki, które nie mają źródła. Po kliknięciu na wiersz dziennika zobaczysz jego pochodne. Możesz schodzić niżej, póki nie skończą się poziomy hierarchii.',
        'nested_parent' => 'Wyświetlono dzienniki pochodzące od :parent.',
        'nested_without'=> 'Wyświetlono wszystkie dzienniki nie posiadające źródła. Kliknij na rząd, by wyświetlić dzienniki pochodne.',
    ],
    'index'         => [
        'add'           => 'Nowy dziennik',
        'header'        => 'Dzienniki elementu :name',
        'title'         => 'Dzienniki',
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
        'tabs'          => [
            'journals'  => 'Dzienniki',
        ],
        'title'         => 'Dziennik :name',
    ],
];
