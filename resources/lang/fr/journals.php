<?php

return [
    'index' => [
        'title' => 'Journaux',
        'description' => 'Gérer les journaux de :name.',
        'add' => 'Nouveau Journal',
        'header' => 'Journaux de :name',
    ],
    'create' => [
        'title' => 'Ajouter un journal',
        'description' => '',
        'success' => 'Journal créé.',
    ],
    'show' => [
        'title' => 'Journal :name',
        'description' => 'Détail d\'un journal',
    ],
    'edit' => [
        'title' => 'Modifier Journal :name',
        'description' => '',
        'success' => 'Journal modifié.',
    ],
    'destroy' => [
        'success' => 'Journal supprimé.',
    ],

    'fields' => [
        'relation' => 'Relation',
        'name' => 'Nom',
        'type' => 'Type',
        'history' => 'Histoire',
        'date' => 'Date',
        'image' => 'Image',
    ],
    'placeholders' => [
        'name' => 'Nom du journal',
        'type' => 'Session, One Shot, Brouillon',
        'date' => 'Date du journal',
    ],
];
