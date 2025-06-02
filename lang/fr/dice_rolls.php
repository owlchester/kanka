<?php

return [
    'create'        => [
        'title' => 'Nouveau jet de dés',
    ],
    'destroy'       => [
        'dice_roll' => 'Jet de dés retiré.',
    ],
    'fields'        => [
        'created_at'    => 'Jeté à',
        'parameters'    => 'Paramètres',
        'results'       => 'Résultats',
        'rolls'         => 'Jets',
    ],
    'hints'         => [
        'parameters'    => 'Quelles sont mes options de dés?',
    ],
    'index'         => [
        'actions'   => [
            'results'   => 'Résultats',
        ],
    ],
    'placeholders'  => [
        'name'          => 'Nom du jet de dés',
        'parameters'    => '4d6+3',
    ],
    'results'       => [
        'actions'   => [
            'add'   => 'Jet',
        ],
        'error'     => 'Problème lors du jet de dés. Les paramêtres ne sont pas conformes.',
        'fields'    => [
            'creator'   => 'Créateur',
            'date'      => 'Date',
            'result'    => 'Résultat',
        ],
        'hint'      => 'Tous les jets de ce modèle.',
        'success'   => 'Dés jetés.',
    ],
    'show'          => [
        'tabs'  => [
            'results'   => 'Résultats',
        ],
    ],
];
