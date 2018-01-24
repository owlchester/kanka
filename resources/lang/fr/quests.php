<?php

return [
    'index' => [
        'title' => 'Quêtes',
        'description' => 'Gérer les quêtes de :name.',
        'add' => 'Nouvelle Quête',
        'header' => 'Quêtes de :name',
    ],
    'create' => [
        'title' => 'Ajouter une quête',
        'description' => '',
        'success' => 'Quête \':name\' créée.',
    ],
    'show' => [
        'title' => 'Quête :name',
        'description' => 'Détail de la quête',
        'tabs' => [
            'information' => 'Infourmation',
            'characters' => 'Personnages',
            'locations' => 'Lieux',
        ],
        'actions' => [
            'add_location' => 'Ajouter un lieu',
            'add_character' => 'Ajouter un personnage',
        ],
    ],
    'edit' => [
        'title' => 'Modifier Quête :name',
        'description' => '',
        'success' => 'Quête \':name\' modifiée.',
    ],
    'destroy' => [
        'success' => 'Quête \':name\' supprimée.',
    ],

    'fields' => [
        'name' => 'Nom',
        'type' => 'Type',
        'description' => 'Description',
        'image' => 'Image',
        'characters' => 'Personnages',
        'locations' => 'Lieux',
    ],
    'placeholders' => [
        'name' => 'Nom de la quête',
        'type' => 'Principale, side quest, personnage',
    ],
    'characters' => [
        'create' => [
            'title' => 'Nouveau personnage pour :name',
            'description' => 'Lier un personnage à la quête',
            'success' => 'Personnage ajouté à :name.',
        ],
        'edit' => [
            'title' => 'Modifier un personnage pour :name',
            'description' => '',
            'success' => 'Personnage pour :name modifié.',
        ],
        'fields' => [
            'character' => 'Personnage',
            'description' => 'Description',
        ],
        'destroy' => [
            'success' => 'Personnage pour :name supprimé.',
        ]
    ],
    'locations' => [
        'create' => [
            'title' => 'Nouveau lieu pour :name',
            'description' => 'Lier un lieu à la quête',
            'success' => 'Lieu ajouté à :name.',
        ],
        'edit' => [
            'title' => 'Modifier lieu pour :name',
            'description' => '',
            'success' => 'Lieu pour :name modifié.',
        ],
        'fields' => [
            'location' => 'Lieu',
            'description' => 'Description',
        ],
        'destroy' => [
            'success' => 'Lieu pour :name supprimé.',
        ]
    ],
];
