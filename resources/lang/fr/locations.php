<?php

return [
    'create'        => [
        'description'   => '',
        'success'       => 'Lieu \':name\' créé.',
        'title'         => 'Ajouter un lieu',
    ],
    'destroy'       => [
        'success'   => 'Lieu \':name\' supprimé.',
    ],
    'edit'          => [
        'description'   => '',
        'success'       => 'Lieu \':name\' modifié.',
        'title'         => 'Modifier Lieu :name',
    ],
    'fields'        => [
        'characters'    => 'Personnages',
        'description'   => 'Description',
        'history'       => 'Histoire',
        'image'         => 'Image',
        'location'      => 'Lieu',
        'locations'     => 'Lieux',
        'name'          => 'Nom',
        'relation'      => 'Relation',
        'type'          => 'Type',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Mode Exploration',
        ],
        'add'           => 'New Lieu',
        'description'   => 'Gérer les lieux of :name.',
        'header'        => 'Lieux de :name',
        'title'         => 'Lieux',
    ],
    'placeholders'  => [
        'location'  => 'Choix d\'un lieu parent',
        'name'      => 'Nom du lieu',
        'type'      => 'Village, Royaume, Ruine',
    ],
    'show'          => [
        'description'   => 'Détail d\'un lieu',
        'tabs'          => [
            'attributes'    => 'Attributs',
            'characters'    => 'Personnages',
            'information'   => 'Information',
            'locations'     => 'Lieux',
            'relations'     => 'Relations',
            'map'           => 'Carte',
        ],
        'title'         => 'Lieu :name',
    ],
    'map' => [
        'helper' => 'Appuyes sur la carte pour ajouter un lien vers un lieu, ou appuie sur un lien pour le supprimer.',
        'no_map' => 'Ajouter une carte au lieu en premier.',
        'actions' => [
            'points' => 'Modifier les points',
        ],
        'points' => [
            'title' => 'Points pour le lieu :name'
        ],
        'success' => 'Points sauvegardés.',
        'modal' => [
            'title' => 'Cible du nouveau point',
            'submit' => 'Ajouter',
        ]
    ]
];
