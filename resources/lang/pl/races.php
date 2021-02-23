<?php

return [
    'characters'    => [
        'description'   => 'Postaci należące do tej rasy',
        'helpers'       => [
            'all_characters'    => 'Wyświetla wszystkie postaci należące do tej rasy i ras pochodnych.',
            'characters'        => 'Wyświetla wyłącznie postaci należące do tej rasy.',
        ],
        'title'         => 'Postaci rasy :nazwa',
    ],
    'create'        => [
        'description'   => 'Stwórz nową rasę',
        'success'       => 'Stworzono rasę \':name\'.',
        'title'         => 'Nowa rasa',
    ],
    'destroy'       => [
        'success'   => 'Usunięto rasę \':name\'.',
    ],
    'edit'          => [
        'success'   => 'Zmieniono rasę \':name\'.',
        'title'     => 'Edycja rasy :name',
    ],
    'fields'        => [
        'characters'    => 'Postaci',
        'name'          => 'Nazwa',
        'race'          => 'Rasa źródłowa',
        'races'         => 'Rasy pochodne',
        'type'          => 'Rodzaj',
    ],
    'helpers'       => [
        'nested'    => 'W Widoku Hierarchii domyślnie wyświetlane są rasy, które nie mają źródła. Po kliknięciu na rasę zobaczysz jej pochodne. Możesz schodzić niżej, póki nie skończą się poziomy hierarchii.',
    ],
    'index'         => [
        'add'           => 'Nowa rasa',
        'description'   => 'Zarządzaj rasami elementu :name.',
        'header'        => 'Rasy elementu :name',
        'title'         => 'Rasy',
    ],
    'placeholders'  => [
        'name'  => 'Nazwa rasy',
        'type'  => 'Człowiek, sidhe, borg',
    ],
    'races'         => [
        'description'   => 'Rasy nakleżące do tej rasy',
        'title'         => 'Rasy pochodne od :name',
    ],
    'show'          => [
        'description'   => 'Szczegółowy widok rasy',
        'tabs'          => [
            'characters'    => 'Postaci',
            'menu'          => 'Menu',
            'races'         => 'Rasy pochodne',
        ],
        'title'         => 'Rasa :name',
    ],
];
