<?php

return [
    'index' => [
        'title' => 'Familles',
        'description' => 'Gérer les familles de :name.',
        'add' => 'Nouvelle Famille',
        'header' => 'Familles de :name',
    ],
    'create' => [
        'title' => 'Ajouter une Famille',
        'description' => '',
        'success' => 'Famille \':name\' ajoutée.',
    ],
    'show' => [
        'title' => 'Famille :name',
        'description' => 'Détail d\'une famille',
        'tabs' => [
            'history' => 'Histoire',
            'member' => 'Membres',
            'relation' => 'Relations',
        ],
    ],
    'edit' => [
        'title' => 'Modifier la famille :name',
        'description' => '',
        'success' => 'Famille \':name\' modifiée.',
    ],
    'destroy' => [
        'success' => 'Famille \':name\' supprimée.',
    ],

    'fields' => [
        'relation' => 'Relation',
        'name' => 'Nom',
        'location' => 'Lieu',
        'members' => 'Members',
        'image' => 'Image',
        'history' => 'Histoire',
    ],
    'placeholders' => [
        'name' => 'Nom de la famille',
        'location' => 'Choix d\'un lieu',
    ],
];
