<?php

return [
    'index' => [
        'title' => 'Lieux',
        'description' => 'Gérer les lieux of :name.',
        'add' => 'New Lieu',
        'header' => 'Lieux de :name'
    ],
    'create' => [
        'title' => 'Ajouter un lieu',
        'description' => '',
        'success' => 'Lieu \':name\' créé.',
    ],
    'show' => [
        'title' => 'Lieu :name',
        'description' => 'Détail d\'un lieu',
        'tabs' => [
            'information' => 'Information',
            'characters' => 'Personnages',
            'locations' => 'Lieux',
            'relations' => 'Relations',
            'attributes' => 'Attributs',
        ],
    ],
    'edit' => [
        'title' => 'Modifier Lieu :name',
        'description' => '',
        'success' => 'Lieu \':name\' modifié.',
    ],
    'destroy' => [
        'success' => 'Lieu \':name\' supprimé.',
    ],
    'fields' => [
        'name' => 'Nom',
        'type' => 'Type',
        'location' => 'Lieu',
        'characters' => 'Personnages',
        'description' => 'Description',
        'history' => 'Histoire',
        'image' => 'Image',
        'relation' => 'Relation',
    ],
    'placeholders' => [
        'name' => 'Nom du lieu',
        'type' => 'Village, Royaume, Ruine',
        'location' => 'Choix d\'un lieu parent',
    ],
    'attributes' => [
        'create' => [
            'title' => 'Nouvel attribut pour :name',
            'description' => 'Définir un attribut pour un lieu',
            'success' => 'Attribut ajouté à :name.',
        ],
        'actions' => [
            'add' => 'Ajouter un attribut',
        ],
        'edit' => [
            'title' => 'Modifier un attribut pour :name',
            'description' => '',
            'success' => 'Attribut pour :name modifié.',
        ],
        'fields' => [
            'attribute' => 'Attribut',
            'value' =>  'Valeur',
        ],
        'placeholders' => [
            'attribute' => 'Population, Nombre d\'inondations, Taille',
            'value' => 'Valeur de l\'attribut'
        ],
        'destroy' => [
            'success' => 'Attribut pour :name supprimé.',
        ]
    ],
];
