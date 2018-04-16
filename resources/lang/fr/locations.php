<?php

return [
    'create'        => [
        'description'   => 'Créer un nouveau lieu',
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
        'image'         => 'Image',
        'location'      => 'Lieu',
        'locations'     => 'Lieux',
        'map'           => 'Carte',
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
    'map'           => [
        'actions'   => [
            'points'    => 'Modifier les points',
        ],
        'helper'    => 'Appuyes sur la carte pour ajouter un lien vers un lieu, ou appuie sur un lien pour le supprimer.',
        'modal'     => [
            'submit'    => 'Ajouter',
            'title'     => 'Cible du nouveau point',
        ],
        'no_map'    => 'Ajouter une carte au lieu en premier.',
        'points'    => [
            'title' => 'Points pour le lieu :name',
        ],
        'success'   => 'Points sauvegardés.',
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
            'map'           => 'Carte',
            'relations'     => 'Relations',
        ],
        'title'         => 'Lieu :name',
    ],
];
