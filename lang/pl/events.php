<?php

return [
    'create'        => [
        'title' => 'Nowe wydarzenie',
    ],
    'destroy'       => [],
    'edit'          => [],
    'events'        => [
        'helper'    => 'Ty wyświetlone są wydarzenia pochodzące od tego elementu.',
    ],
    'fields'        => [
        'date'  => 'Data',
    ],
    'helpers'       => [
        'date'  => 'W tym polu można umieścić wszystko - nie jest związane z kalendarzami kampanii. By je tam umieścić kalendarzu, dodaj ręcznie epizod za pomocą kalendarza albo zakładki "Epizody" elementu.',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'  => 'Data tego wydarzenia',
        'type'  => 'Uroczystość, festiwal, katastrofa, bitwa, narodziny',
    ],
    'show'          => [],
    'tabs'          => [
        'calendars' => 'Wpisy w kalendarzu',
    ],
];
