<?php

return [
    'create'        => [
        'title' => 'Nowe wydarzenie',
    ],
    'destroy'       => [],
    'edit'          => [],
    'events'        => [
        'helper'    => 'Ty wyświetlone są wydarzenia pochodzące od tego elementu.',
        'title'     => 'Wydarzenia wydarzenia :name',
    ],
    'fields'        => [
        'date'      => 'Data',
        'event'     => 'Wydarzenie źródłowe',
        'events'    => 'Wydarzenia pochodne',
    ],
    'helpers'       => [
        'date'              => 'W tym polu można umieścić wszystko - nie jest związane z kalendarzami kampanii. By umieścić je w kalendarzu, dodaj je ręcznie w menu kalendarza albo zakładce "Ważne daty" wydarzenia.',
        'nested_without'    => 'Wyświetlono wszystkie wydarzenia nieposiadające źródła. Kliknij na rząd, by wyświetlić wydarzenia pochodne.',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'  => 'Data tego wydarzenia',
        'name'  => 'Nazwa wydarzenia',
        'type'  => 'Uroczystość, festiwal, katastrofa, bitwa, narodziny',
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
