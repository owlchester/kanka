<?php

return [
    'create'        => [
        'title' => 'Nový hod kostami',
    ],
    'destroy'       => [
        'dice_roll' => 'Hod kostkami odstraněn.',
    ],
    'edit'          => [],
    'fields'        => [
        'created_at'    => 'Hozeno v',
        'parameters'    => 'Parametry',
        'results'       => 'Výsledky',
        'rolls'         => 'Hody',
    ],
    'hints'         => [
        'parameters'    => 'Možnosti hodu',
    ],
    'index'         => [
        'actions'   => [
            'dice'      => 'Hody kostkou',
            'results'   => 'Výsledky',
        ],
    ],
    'placeholders'  => [
        'dice_roll' => 'Hod kostkou',
        'name'      => 'Název hodu kostkou',
        'parameters'=> '4d6+3',
    ],
    'results'       => [
        'actions'   => [
            'add'   => 'Hodit',
        ],
        'error'     => 'Hod kostkou neúspěšný. Nelze zpracovat parametry.',
        'fields'    => [
            'creator'   => 'Autor',
            'date'      => 'Kalendářní datum',
            'result'    => 'Výsledek',
        ],
        'hint'      => 'Všechny hody kostkou podle této šablony.',
        'success'   => 'Kostky vrženy.',
    ],
    'show'          => [
        'tabs'  => [
            'results'   => 'Výsledky',
        ],
    ],
];
