<?php

return [
    'abilities'     => [
        'title' => 'Zdolności wywodzące się od :name',
    ],
    'create'        => [
        'success'   => 'Stworzono zdolność \':name\'.',
        'title'     => 'Nowa Zdolność',
    ],
    'destroy'       => [
        'success'   => 'Usunięto zdolność \':name\'.',
    ],
    'edit'          => [
        'success'   => 'Zaktualizowano zdolność \':name\'.',
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
        'nested'        => 'W Widoku Zagnieżdżonym na poziomie podstawowym wyświetlane są zdolności, które nie mają źródła. Po kliknięciu na zdolność zobaczysz jej zdolności pochodne. Możesz klikać, póki nie skończą się poziomy zależności.',
    ],
    'index'         => [
        'add'           => 'Nowa Zdolność',
        'description'   => 'Dodawaj moce, czary, atuty i inne zdolności specjalne różnych elementów kampanii.',
        'header'        => 'Zdolności elementu :nazwa',
        'title'         => 'Zdolności',
    ],
    'placeholders'  => [
        'charges'   => 'Liczba ładunków zdolności. Możesz wpisać wartość cechy jako {Level}*{CHA}',
        'name'      => 'Kula ognia, Alarm, Podstępny atak',
        'type'      => 'Czar, umiejętność, technika bojowa',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Zdolności',
        ],
        'title' => 'Zdolność :name',
    ],
];
