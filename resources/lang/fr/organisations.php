<?php

return [
    'index' => [
        'title' => 'Organisations',
        'description' => 'Gérer les organisation de :name.',
        'add' => 'Nouvelle Organisation',
        'header' => 'Organisations de :name',
    ],
    'create' => [
        'title' => 'Ajouter une organisation',
        'description' => '',
        'success' => 'Organisation \':name\' créée.',
    ],
    'show' => [
        'title' => 'Organisation :name',
        'description' => 'Détail de l\'organisation',
        'tabs' => [
            'history' => 'Histoire',
            'members' => 'Membres',
            'relations' => 'Relations',
        ]
    ],
    'edit' => [
        'title' => 'Modifier Organisation :name',
        'description' => '',
        'success' => 'Organisation \':name\' modifiée.',
    ],
    'destroy' => [
        'success' => 'Organisation \':name\' supprimée.',
    ],

    'fields' => [
        'name' => 'Nom',
        'type' => 'Type',
        'location' => 'Lieu',
        'members' => 'Membres',
        'image' => 'Image',
        'history' => 'Histoire',
        'relation' => 'Relation',
    ],
    'placeholders' => [
        'name' => 'Nom de l\'organisation',
        'location' => 'Choix du lieu',
        'type' => 'Culte, Bande, Rebellion',
    ],
    'members' => [
        'create' => [
            'title' => 'Nouveau membre pour :name',
            'description' => 'Ajouter un membre à l\'organisation',
            'success' => 'Membre ajouté à l\'organisation :name.',
        ],
        'actions' => [
            'add' => 'Ajouter un membre',
        ],
        'edit' => [
            'title' => 'Modifier Member pour :name',
            'description' => '',
            'success' => 'Membre modifié.',
        ],
        'fields' => [
            'role' => 'Rôle',
            'character' => 'Personnage',
        ],
        'placeholders' => [
            'role' => 'Chef, Membre, Prêtre, Maître d\'arme',
            'character' => 'Choix du personnage'
        ],
        'destroy' => [
            'success' => 'Membre retiré de l\'organisation',
        ]
    ],
];
