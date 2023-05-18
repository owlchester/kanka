<?php

return [
    'create'        => [
        'title' => 'Nieuwe Dobbelsteen Worp',
    ],
    'destroy'       => [
        'dice_roll' => 'Dobbelsteen worp verwijderd.',
    ],
    'edit'          => [],
    'fields'        => [
        'created_at'    => 'Gerold Bij',
        'parameters'    => 'Parameters',
        'results'       => 'Resultaten',
        'rolls'         => 'Worpen',
    ],
    'hints'         => [
        'parameters'    => 'Wat zijn mijn dobbelsteen opties?',
    ],
    'index'         => [
        'actions'   => [
            'results'   => 'Resultaten',
        ],
    ],
    'placeholders'  => [
        'name'          => 'Naam van de Dobbelsteen Worp',
        'parameters'    => '4d6+3',
    ],
    'results'       => [
        'actions'   => [
            'add'   => 'Worp',
        ],
        'error'     => 'Dobbelsteen worp mislukt. Kan de parameters niet parseren.',
        'fields'    => [
            'creator'   => 'Maker',
            'date'      => 'Datum',
            'result'    => 'Resultaat',
        ],
        'hint'      => 'Alle worpen gedaan voor deze dobbelsteen worp sjabloon.',
        'success'   => 'Dobbelstenen gegooid.',
    ],
    'show'          => [
        'tabs'  => [
            'results'   => 'Resultaten',
        ],
    ],
];
