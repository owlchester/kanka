<?php

return [
    'fields'    => [
        'type'  => 'Rodzaj wydarzenia',
    ],
    'helpers'   => [
        'characters'    => 'Ustawienie rodzaju jako daty narodzin albo śmieci tej postaci automatycznie wyliczy jej wiek. :more.',
    ],
    'show'      => [
        'actions'   => [
            'add'   => 'Dodaj datę',
        ],
        'title'     => 'Ważne daty :name',
    ],
    'types'     => [
        'birth'     => 'Narodziny',
        'death'     => 'Śmierć',
        'primary'   => 'Główna',
    ],
];
