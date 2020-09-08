<?php

return [
    'create'        => [
        'description'   => 'Créer un nouveau jet de dés',
        'success'       => 'Jet de dés \':name\' créé.',
        'title'         => 'Nouveau jet de dés',
    ],
    'destroy'       => [
        'dice_roll' => 'Jet de dés retiré.',
        'success'   => 'Jet de dés \':name\' retiré.',
    ],
    'edit'          => [
        'description'   => 'Modifier un jet de dés',
        'success'       => 'Jet de dés \':name\' modifié.',
        'title'         => 'Modifier le jet de dés :name',
    ],
    'fields'        => [
        'created_at'    => 'Jeté à',
        'name'          => 'Nom',
        'parameters'    => 'Paramètres',
        'results'       => 'Résultats',
        'rolls'         => 'Jets',
    ],
    'hints'         => [
        'parameters'    => 'Quelles sont mes options de dés?',
    ],
    'index'         => [
        'actions'       => [
            'dice'      => 'Jets de dés',
            'results'   => 'Résultats',
        ],
        'add'           => 'Nouveau jet de dés',
        'description'   => 'Gérer les jet de dés de :name.',
        'header'        => 'Jets de dés pour :name',
        'title'         => 'Jets de dés',
    ],
    'placeholders'  => [
        'dice_roll' => 'Jet de dés',
        'name'      => 'Nom du jet de dés',
        'parameters'=> '4d6+3',
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
        'description'   => 'Détails d\'un jet de dés',
        'tabs'          => [
            'results'   => 'Résultats',
        ],
        'title'         => 'Jet de dés :name',
    ],
];
