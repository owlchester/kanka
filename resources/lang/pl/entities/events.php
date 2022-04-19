<?php

return [
    'fields'    => [
        'type'  => 'Rodzaj wydarzenia',
    ],
    'helpers'   => [
        'characters'    => 'Ustawienie rodzaju jako daty narodzin albo śmieci tej postaci automatycznie wyliczy jej wiek. :more.',
        'no_events'     => 'Wyświetla wszystkie kalendarze, z którymi ten element jest związany przez przypomnienia.',
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
