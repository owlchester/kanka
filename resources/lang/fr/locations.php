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
        'add'           => 'Nouveau Lieu',
        'description'   => 'Gérer les lieux of :name.',
        'header'        => 'Lieux de :name',
        'title'         => 'Lieux',
    ],
    'map'           => [
        'actions'   => [
            'big'           => 'Vue Complète',
            'download'      => 'Télécharger',
            'points'        => 'Modifier les points',
            'toggle_hide'   => 'Cacher les Points',
            'toggle_show'   => 'Afficher les Points',
            'zoom_in'       => 'Agrandir',
            'zoom_out'      => 'Dézoomer',
        ],
        'helper'    => 'Appuyes sur la carte pour ajouter un lien vers un lieu, ou appuie sur un lien pour le supprimer.',
        'modal'     => [
            'submit'    => 'Ajouter',
            'title'     => 'Cible du nouveau point',
        ],
        'no_map'    => 'Ajouter une carte au lieu en premier.',
        'points'    => [
            'fields'        => [
                'axis_x'    => 'Axis X',
                'axis_y'    => 'Axis Y',
                'colour'    => 'Couleur',
                'name'      => 'Label',
            ],
            'helpers'       => [
                'location_or_name'  => 'Un point peut être soit un lieu existant, soit un label.',
            ],
            'placeholders'  => [
                'axis_x'    => 'Position verticale',
                'axis_y'    => 'Position horizontale',
                'name'      => 'Label du point quand il n\'y a pas de lieu.',
            ],
            'return'        => 'Retour à :name',
            'success'       => [
                'create'    => 'Point ajouté.',
                'delete'    => 'Point retiré.',
                'update'    => 'Point modifié.',
            ],
            'title'         => 'Points pour le lieu :name',
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
            'characters'    => 'Personnages',
            'information'   => 'Information',
            'locations'     => 'Lieux',
            'map'           => 'Carte',
        ],
        'title'         => 'Lieu :name',
    ],
];
