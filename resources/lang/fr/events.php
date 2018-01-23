<?php

return [
    'index' => [
        'title' => 'Événements',
        'description' => 'Gestion des événements de :name.',
        'add' => 'Nouvel Événement',
        'header' => 'Événements de :name',
    ],
    'create' => [
        'title' => 'Créer un nouvel Événement',
        'description' => '',
        'success' => 'Événement \':name\' créé.',
    ],
    'show' => [
        'title' => 'Événement :name',
        'description' => 'Détail d\'un événement',
        'tabs' => [
            'information' => 'Information',
        ],
    ],
    'edit' => [
        'title' => 'Modifier l\'événement :name',
        'description' => '',
        'success' => 'Événement \':name\' modifier.',
    ],
    'destroy' => [
        'success' => 'Événement \':name\' supprimé.',
    ],

    'fields' => [
        'name' => 'Nom',
        'location' => 'Lieu',
        'type' => 'Type',
        'date' => 'Date',
        'history' => 'Histoire',
        'image' => 'Image',
    ],
    'placeholders' => [
        'name' => 'Nom de l\'événement',
        'type' => 'Cérémonie, Festival, Désastre, Bataille, Naissance',
        'date' => 'La date de l\'événement',
        'location' => 'Choix d\'un lieu',
    ],
];
