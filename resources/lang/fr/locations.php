<?php

return [
    'characters'    => [
        'description'   => 'Personnages qui se trouvent dans ce lieu.',
        'title'         => 'Personnages situé dans :name',
    ],
    'create'        => [
        'description'   => 'Créer un nouveau lieu',
        'success'       => 'Lieu \':name\' créé.',
        'title'         => 'Ajouter un lieu',
    ],
    'destroy'       => [
        'success'   => 'Lieu \':name\' supprimé.',
    ],
    'edit'          => [
        'success'   => 'Lieu \':name\' modifié.',
        'title'     => 'Modifier Lieu :name',
    ],
    'events'        => [
        'description'   => 'Evénements qui se sont déroulé dans ce lieu.',
        'title'         => 'Evénements du lieu :name',
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
    'helpers'       => [
        'nested'    => 'Ce mode de naviguation permet d\'afficher tes lieux de manière imbriquée. Les lieux sans lieu parent seront affichés par défaut. Les lieux possédant des sous-lieux peuvent être cliqués pour afficher ces enfants. Tu peux continuer à cliquer jusqu\'à ce qu\'il n\'y ait plus d\'enfants à voir.',
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
    'items'         => [
        'description'   => 'Objets situés dans ce lieu.',
        'title'         => 'Objets du lieu :name',
    ],
    'locations'     => [
        'description'   => 'Lieu situé dans ce lieu.',
        'title'         => 'Sous-lieux du lieu :name',
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
    'organisations' => [
        'description'   => 'Organisations se situant à ce lieu.',
        'title'         => 'Organisations du lieu :name',
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
            'events'        => 'Evénements',
            'information'   => 'Information',
            'items'         => 'Objets',
            'locations'     => 'Lieux',
            'map'           => 'Carte',
            'menu'          => 'Menu',
            'organisations' => 'Organisations',
        ],
        'title'         => 'Lieu :name',
    ],
];
