<?php

return [
    'fields'    => [
        'type'  => 'Typ udalosti',
    ],
    'helpers'   => [
        'characters'    => 'Ak nastavíš typ ako dátum narodenia alebo smrti, systém vypočíta automaticky pre túto postavu jej vek. :more',
    ],
    'show'      => [
        'actions'   => [
            'add'   => 'Pridať pripomienku',
        ],
        'title'     => 'Pripomienky :name',
    ],
    'types'     => [
        'birth'     => 'Narodenie',
        'death'     => 'Smrť',
        'primary'   => 'Primárny',
    ],
];
