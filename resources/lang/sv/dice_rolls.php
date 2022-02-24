<?php

return [
    'create'        => [
        'success'   => 'Tärningskast \':name\' skapat.',
        'title'     => 'Nytt Tärningskast',
    ],
    'destroy'       => [
        'dice_roll' => 'Tärningskast borttaget.',
        'success'   => 'Tärningskast \':name\' borttaget.',
    ],
    'edit'          => [
        'success'   => 'Tärningskast \':name\' uppdaterat.',
        'title'     => 'Redigera Tärningskast :name',
    ],
    'fields'        => [
        'created_at'    => 'Kastat vid',
        'name'          => 'Namn',
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
        'add'       => 'Nytt Tärningskast',
        'header'    => 'Tärningskast för :name',
        'title'     => 'Tärningskast',
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
        'title' => 'Tärningskast :name',
    ],
];
