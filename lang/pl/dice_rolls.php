<?php

return [
    'create'        => [
        'title' => 'Nowy rzut kośćmi',
    ],
    'destroy'       => [
        'dice_roll' => 'Usunięto rzut kośćmi.',
    ],
    'edit'          => [],
    'fields'        => [
        'created_at'    => 'Rzucono w',
        'parameters'    => 'Parametry',
        'results'       => 'Wyniki',
        'rolls'         => 'Rzuty',
    ],
    'hints'         => [
        'parameters'    => 'Jak opisywać rzut kośćmi?',
    ],
    'index'         => [
        'actions'   => [
            'results'   => 'Wyniki',
        ],
    ],
    'placeholders'  => [
        'name'          => 'Nazwa rzutu kośćmi',
        'parameters'    => '4d6+3',
    ],
    'results'       => [
        'actions'   => [
            'add'   => 'Rzuć',
        ],
        'error'     => 'Rzut nieudany. Nie można przetworzyć parametrów.',
        'fields'    => [
            'creator'   => 'Rzucający',
            'date'      => 'Data',
            'result'    => 'Wynik',
        ],
        'hint'      => 'Wszystkie rzuty wykonane dla tego szablonu rzutów kośćmi.',
        'success'   => 'Kości zostały rzucone.',
    ],
    'show'          => [
        'tabs'  => [
            'results'   => 'Wyniki',
        ],
    ],
];
