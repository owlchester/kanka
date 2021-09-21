<?php

return [
    'create'        => [
        'description'   => 'Vytvořit nový hod kostkami',
        'success'       => 'Hod kostkami ":name" vytvořen.',
        'title'         => 'Nový hod kostami',
    ],
    'destroy'       => [
        'dice_roll' => 'Hod kostkami odstraněn.',
        'success'   => 'Hod kostkami ":name" odstraněn.',
    ],
    'edit'          => [
        'description'   => 'Upravit hod kostkami',
        'success'       => 'Hod kostkami ":name" upraven.',
        'title'         => 'Upravit hod kostkami :name',
    ],
    'fields'        => [
        'created_at'    => 'Hozeno v',
        'name'          => 'Název',
        'parameters'    => 'Parametry',
        'results'       => 'Výsledky',
        'rolls'         => 'Hody',
    ],
    'hints'         => [
        'parameters'    => 'Možnosti hodu',
    ],
    'index'         => [
        'actions'       => [
            'dice'      => 'Hody kostkou',
            'results'   => 'Výsledky',
        ],
        'add'           => 'Nový hod kostkou',
        'description'   => 'Spravovat hody kostkou :name.',
        'header'        => 'Hody kostkou :name',
        'title'         => 'Hody kostkou',
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
        'description'   => 'Podrobný pohled na vrh kostkou',
        'tabs'          => [
            'results'   => 'Výsledky',
        ],
        'title'         => 'Hod kostkou :name',
    ],
];
