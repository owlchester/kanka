<?php

return [
    'abilities'     => [
        'title' => 'Zdolności wywodzące się od :name',
    ],
    'create'        => [
        'success'   => 'Stworzono zdolność \':name\'.',
        'title'     => 'Nowa zdolność',
    ],
    'destroy'       => [
        'success'   => 'Usunięto zdolność \':name\'.',
    ],
    'edit'          => [
        'success'   => 'Zmieniono zdolność \':name\'.',
        'title'     => 'Edycja zdolności :name',
    ],
    'fields'        => [
        'abilities' => 'Zdolności',
        'ability'   => 'Zdolność źródłowa',
        'charges'   => 'Ładunki',
        'name'      => 'Nazwa',
        'type'      => 'Rodzaj',
    ],
    'helpers'       => [
        'descendants'   => 'Na liście znajdują się wszystkie zdolności pochodzące od tej zdolności, nie tylko bezpośrednio.',
        'nested'        => 'W Widoku Hierarchii domyślnie wyświetlane są zdolności, które nie mają źródła. Po kliknięciu na zdolność zobaczysz jej pochodne. Możesz schodzić niżej, póki nie skończą się poziomy hierarchii.',
    ],
    'index'         => [
        'add'           => 'Nowa zdolność',
        'description'   => 'Dodawaj moce, czary, atuty i inne zdolności specjalne różnych elementów kampanii.',
        'header'        => 'Zdolności elementu :nazwa',
        'title'         => 'Zdolności',
    ],
    'placeholders'  => [
        'charges'   => 'Liczba ładunków zdolności. Możesz wpisać wartość cechy jako {Level}*{CHA}',
        'name'      => 'Kula ognia, alarm, podstępny atak',
        'type'      => 'Czar, umiejętność, technika bojowa',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Zdolności',
        ],
        'title' => 'Zdolność :name',
    ],
];
