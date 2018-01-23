<?php

return [
    'fields' => [
        'target' => 'Cible',
        'relation' => 'Relation',
        'two_way' => 'Créer une relation miroir',
    ],
    'placeholders' => [
        'target' => 'Choix d\'un élément',
        'relation' => 'Nature de la relation',
    ],
    'hints' => [
        'two_way' => 'Sélectionne pour créer une copie de la relation sur la cible.',
    ],
    'create' => [
        'success' => 'Relation ajoutée pour :name.',
        'title' => 'Nouvelle relation pour :name',
        'description' => '',
    ],
    'edit' => [
        'success' => 'Relation modifiée pour :name.',
        'title' => 'Modifier la relation de :name',
        'description' => '',
    ],
    'destroy' => [
        'success' => 'Relation supprimée pour :name.',
    ]
];
