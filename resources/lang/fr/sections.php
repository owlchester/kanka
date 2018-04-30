<?php

return [
    'create'        => [
        'description'   => 'Ajouter une nouvelle catégorie',
        'success'       => 'Nouvelle catégorie \':name\' ajoutée.',
        'title'         => 'Nouvelle Catégorie',
    ],
    'destroy'       => [
        'success'   => 'La catégorie \':name\' a été retirée.',
    ],
    'edit'          => [
        'success'   => 'La catégorie \':name\' a été mise à jour.',
        'title'     => 'Modifier la catégorie :name',
    ],
    'fields'        => [
        'characters'    => 'Personnages',
        'children'      => 'Enfants',
        'name'          => 'Nom',
        'section'       => 'Catégorie',
        'sections'      => 'Sous-catégories',
        'type'          => 'Type',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Mode Exploration',
        ],
        'add'           => 'Nouvelle Catégorie',
        'description'   => 'Gérer les catégories pour :name.',
        'header'        => 'Les catégories dans :name',
        'title'         => 'Catégories',
    ],
    'placeholders'  => [
        'name'      => 'Nom de la catégorie',
        'section'   => 'Choix de la catégorie parent',
        'type'      => 'Légende, Guerres, Histoire, Religion',
    ],
    'show'          => [
        'description'   => 'Vue détaillée de la catégorie',
        'tabs'          => [
            'children'      => 'Enfants',
            'information'   => 'Information',
            'sections'      => 'Catégories',
        ],
        'title'         => 'Catégorie :name',
    ],
];
