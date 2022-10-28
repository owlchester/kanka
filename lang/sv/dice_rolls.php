<?php

return [
    'create'        => [
        'title' => 'Nytt Tärningskast',
    ],
    'destroy'       => [
        'dice_roll' => 'Tärningskast borttaget.',
    ],
    'edit'          => [],
    'fields'        => [
        'created_at'    => 'Kastat vid',
        'parameters'    => 'Parametrar',
        'results'       => 'Resultat',
        'rolls'         => 'Kast',
    ],
    'hints'         => [
        'parameters'    => 'Vad är mina tärnings alternativ?',
    ],
    'index'         => [
        'actions'   => [
            'dice'      => 'Tärningskast',
            'results'   => 'Resultat',
        ],
    ],
    'placeholders'  => [
        'dice_roll' => 'Tärningskast',
        'name'      => 'Namn på Tärningskastet',
        'parameters'=> '4d6+3',
    ],
    'results'       => [
        'actions'   => [
            'add'   => 'Kasta',
        ],
        'error'     => 'Tärningskast misslyckat. Kan inte tolka parametrarna.',
        'fields'    => [
            'creator'   => 'Skapare',
            'date'      => 'Datum',
            'result'    => 'Resultat',
        ],
        'hint'      => 'All kasten gjorda för denna tärningskast-mallen.',
        'success'   => 'Tärningarna är kastade.',
    ],
    'show'          => [
        'tabs'  => [
            'results'   => 'Resultat',
        ],
    ],
];
