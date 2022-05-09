<?php

return [
    'create'        => [
        'success'   => 'Stworzono wydarzenie \':name\'.',
        'title'     => 'Nowe wydarzenie',
    ],
    'destroy'       => [
        'success'   => 'Usunięto wydarzenie \':name\'.',
    ],
    'edit'          => [
        'success'   => 'Zmieniono wydarzenie \':name\'.',
        'title'     => 'Edycja wydarzenia :name',
    ],
    'events'        => [
        'helper'    => 'Ty wyświetlone są wydarzenia pochodzące od tego elementu.',
        'title'     => 'Wydarzenia wydarzenia :name',
    ],
    'fields'        => [
        'date'      => 'Data',
        'event'     => 'Wydarzenie źródłowe',
        'events'    => 'Wydarzenia pochodne',
        'image'     => 'Obraz',
        'location'  => 'Miejsce',
        'name'      => 'Nazwa',
        'type'      => 'Rodzaj',
    ],
    'helpers'       => [
        'date'          => 'W tym polu można umieścić wszystko - nie jest związane z kalendarzami kampanii. By umieścić je w kalendarzu, dodaj je ręcznie w menu kalendarza albo zakładce "Ważne daty" wydarzenia.',
        'nested_parent' => 'Wyświetlono wydarzenia pochodzące od :parent.',
        'nested_without'=> 'Wyświetlono wszystkie wydarzenia nie posiadające źródła. Kliknij na rząd, by wyświetlić wydarzenia pochodne.',
    ],
    'index'         => [
        'title' => 'Wydarzenia',
    ],
    'placeholders'  => [
        'date'      => 'Data tego wydarzenia',
        'location'  => 'Wybierz miejsce',
        'name'      => 'Nazwa wydarzenia',
        'type'      => 'Uroczystość, festiwal, katastrofa, bitwa, narodziny',
    ],
    'show'          => [
        'tabs'  => [
            'events'    => 'Wydarzenia',
        ],
    ],
    'tabs'          => [
        'calendars' => 'Wpisy w kalendarzu',
    ],
];
