<?php

return [
    'create'        => [
        'description'   => 'Stwórz nowy dziennik',
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
        'journals'  => 'Wyświetla wszystkie dzienniki pochodne, albo tylko pochodzące bezpośrednio od tego.',
        'nested'    => 'W Widoku Hierarchii domyślnie wyświetlane są dzienniki, które nie mają źródła. Po kliknięciu na dziennik zobaczysz jego pochodne. Możesz schodzić niżej, póki nie skończą się poziomy hierarchii.',
    ],
    'index'         => [
        'add'           => 'Nowy dziennik',
        'description'   => 'Zarządzaj dziennikami elementu :nazwa.',
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
        'description'   => 'Szczególowy widok dziennika',
        'tabs'          => [
            'journals'  => 'Dzienniki',
        ],
        'title'         => 'Dziennik :name',
    ],
];
