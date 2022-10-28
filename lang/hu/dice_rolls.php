<?php

return [
    'create'        => [
        'title' => 'Új dobás',
    ],
    'destroy'       => [
        'dice_roll' => 'A dobást eltávolítottuk.',
    ],
    'edit'          => [],
    'fields'        => [
        'created_at'    => 'Dobott',
        'parameters'    => 'Paraméterek',
        'results'       => 'Eredmények',
        'rolls'         => 'Dobások',
    ],
    'hints'         => [
        'parameters'    => 'Milyen kockákat használhatok?',
    ],
    'index'         => [
        'actions'   => [
            'dice'      => 'Dobások',
            'results'   => 'Eredmények',
        ],
    ],
    'placeholders'  => [
        'dice_roll' => 'Dobás',
        'name'      => 'Dobás megnevezése',
        'parameters'=> '4d6+3',
    ],
    'results'       => [
        'actions'   => [
            'add'   => 'Gurítás',
        ],
        'error'     => 'A dobás sikertelen. Nem tudjuk értelmezni a paramétereket.',
        'fields'    => [
            'creator'   => 'Létrehozó',
            'date'      => 'Dátum',
            'result'    => 'Eredmény',
        ],
        'hint'      => 'Ehhez a dobássablonhoz minden dobás kész van.',
        'success'   => 'Elgurítottad a kockákat.',
    ],
    'show'          => [
        'tabs'  => [
            'results'   => 'Eredmények',
        ],
    ],
];
