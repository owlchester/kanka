<?php

return [
    'create'        => [
        'success'   => 'Stworzono rzut kośćmi ":name\'.',
        'title'     => 'Nowy rzut kośćmi',
    ],
    'destroy'       => [
        'dice_roll' => 'Usunięto rzut kośćmi.',
        'success'   => 'Usunięto rzut kośćmi \':name\'.',
    ],
    'edit'          => [
        'success'   => 'Zmieniono rzut kośćmi \':name\'.',
        'title'     => 'Edycja rzutu kośćmi :name',
    ],
    'fields'        => [
        'created_at'    => 'Rzucono w',
        'name'          => 'Nazwa',
        'parameters'    => 'Parametry',
        'results'       => 'Wyniki',
        'rolls'         => 'Rzuty',
    ],
    'hints'         => [
        'parameters'    => 'Jak opisywać rzut kośćmi?',
    ],
    'index'         => [
        'actions'   => [
            'dice'      => 'Rzuty kości',
            'results'   => 'Wyniki',
        ],
        'add'       => 'Nowy rzut kośćmi',
        'header'    => 'Rzuty kośćmi dla :name',
        'title'     => 'Rzuty kośćmi',
    ],
    'placeholders'  => [
        'dice_roll' => 'Rzut kośćmi',
        'name'      => 'Nazwa rzutu kośćmi',
        'parameters'=> '4d6+3',
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
        'title' => 'Rzut kośćmi :name',
    ],
];
