<?php

return [
    'index' => [
        'title' => 'Objets',
        'description' => 'Gestion des objets de :name.',
        'add' => 'Nouvel Objet',
        'header' => 'Objets de :name',
    ],
    'create' => [
        'title' => 'Ajouter un objet',
        'description' => '',
        'success' => 'Objet \':name\' créé.',
    ],
    'show' => [
        'title' => 'Objet :name',
        'description' => 'Détail d\'un objet',
        'tabs' => [
            'information' => 'Information',
        ],
    ],
    'edit' => [
        'title' => 'Modifier Objet :name',
        'description' => '',
        'success' => 'Objet \':name\' modifié.',
    ],
    'destroy' => [
        'success' => 'Objet \':name\' supprimé.',
    ],
    'fields' => [
        'relation' => 'Relation',
        'name' => 'Nom',
        'location' => 'Lieu',
        'type' => 'Type',
        'character' => 'Personnage',
        'history' => 'Histoire',
        'image' => 'Image',
        'description' => 'Description',
    ],
    'placeholders' => [
        'name' => 'Nom de l\'objet',
        'type' => 'Arme, Potion, Coffre',
        'location' => 'Choix d\'un lieu',
        'character' => 'Choix d\un personnage',
    ],
];
