<?php

return [
    '403'       => [
        'body'  => 'No teniu permís per accedir a aquesta pàgina.',
        'title' => 'Permís denegat',
    ],
    '403-form'  => [
        'help'  => 'Pot ser que la vostra sessió hagi caducat. Proveu d\'iniciar sessió en una altra finestra abans de guardar.',
    ],
    '404'       => [
        'body'  => 'La pàgina que busqueu no s\'ha trobat.',
        'title' => 'Pàgina no trobada',
    ],
    '500'       => [
        'body'  => [
            '1' => 'Sembla que alguna cosa no va bé.',
            '2' => 'S\'ha enviat un informe amb aquest error, però si ens podeu dir el que estàveu fent, ens seria de molta ajuda..',
        ],
        'title' => 'Error',
    ],
    '503'       => [
        'body'  => [
            '1' => 'Kanka està en manteniment ara mateix. És possible que hi hagi una actualització en camí!',
            '2' => 'Disculpeu les molèsties. Tot tornarà a la normalitat en tan sols uns minuts.',
        ],
        'title' => 'Manteniment',
    ],
    '503-form'  => [],
    'footer'    => 'Per a més assistència, contacteu-nos a hello@kanka.io o al :discord',
];
