<?php

return [
    'create'        => [
        'description'   => 'Skapa ett nytt tärningskast',
        'success'       => 'Tärningskast \':name\' skapat.',
        'title'         => 'Nytt Tärningskast',
    ],
    'destroy'       => [
        'dice_roll' => 'Tärningskast borttaget.',
        'success'   => 'Tärningskast \':name\' borttaget.',
    ],
    'edit'          => [
        'description'   => 'Redigera tärningskast',
        'success'       => 'Tärningskast \':name\' uppdaterat.',
        'title'         => 'Redigera Tärningskast :name',
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
        'actions'       => [
            'dice'      => 'Tärningskast',
            'results'   => 'Resultat',
        ],
        'add'           => 'Nytt Tärningskast',
        'description'   => 'Hantera tärningskast för :name',
        'header'        => 'Tärningskast för :name',
        'title'         => 'Tärningskast',
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
        'description'   => 'En detaljerad vy för ett Tärningskast',
        'tabs'          => [
            'results'   => 'Resultat',
        ],
        'title'         => 'Tärningskast :name',
    ],
];
