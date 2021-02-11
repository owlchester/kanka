<?php

return [
    'create'        => [
        'description'   => 'Stwórz nowe wydarzenie',
        'success'       => 'Stworzono wydarzenie \':name\'.',
        'title'         => 'Nowe Wydarzenie',
    ],
    'destroy'       => [
        'success'   => 'Usunięto wydarzenie \':name\'.',
    ],
    'edit'          => [
        'success'   => 'Zaktualizowano wydarzenie \':name\'.',
        'title'     => 'Edycja Wydarzenia :name',
    ],
    'fields'        => [
        'date'      => 'Data',
        'image'     => 'Obraz',
        'location'  => 'Miejsce',
        'name'      => 'Nazwa',
        'type'      => 'Rodzaj',
    ],
    'helpers'       => [
        'date'  => 'W tym polu można umieścić wszystko - nie jest związane z kalendarzami kampanii. By umieścić je w kalendarzu, dodaj je ręcznie w menu kalendarza albo zakładce przypomnień wydarzenia.',
    ],
    'index'         => [
        'add'           => 'Nowe wydarzenie',
        'description'   => 'Zarządzaj wydarzeniami elementu :name.',
        'header'        => 'Wydarzenia elementu :name',
        'title'         => 'Wydarzenia',
    ],
    'placeholders'  => [
        'date'      => 'Data tego wydarzenia',
        'location'  => 'Wybierz miejsce',
        'name'      => 'Nazwa wydarzenia',
        'type'      => 'Uroczystość, festiwal, katastrofa, bitwa, narodziny',
    ],
    'show'          => [
        'description'   => 'Szczegółowy opis wydarzenia',
        'tabs'          => [
            'information'   => 'Informacje',
        ],
        'title'         => 'Wydarzenie :name',
    ],
    'tabs'          => [
        'calendars' => 'Wpisy w kalendarzu',
    ],
];
