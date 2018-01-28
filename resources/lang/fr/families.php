<?php

return [
    'create'        => [
        'description'   => '',
        'success'       => 'Famille \':name\' ajoutée.',
        'title'         => 'Ajouter une Famille',
    ],
    'destroy'       => [
        'success'   => 'Famille \':name\' supprimée.',
    ],
    'edit'          => [
        'description'   => '',
        'success'       => 'Famille \':name\' modifiée.',
        'title'         => 'Modifier la famille :name',
    ],
    'fields'        => [
        'history'   => 'Histoire',
        'image'     => 'Image',
        'location'  => 'Lieu',
        'members'   => 'Members',
        'name'      => 'Nom',
        'relation'  => 'Relation',
    ],
    'index'         => [
        'add'           => 'Nouvelle Famille',
        'description'   => 'Gérer les familles de :name.',
        'header'        => 'Familles de :name',
        'title'         => 'Familles',
    ],
    'placeholders'  => [
        'location'  => 'Choix d\'un lieu',
        'name'      => 'Nom de la famille',
    ],
    'show'          => [
        'description'   => 'Détail d\'une famille',
        'tabs'          => [
            'history'   => 'Histoire',
            'member'    => 'Membres',
            'relation'  => 'Relations',
        ],
        'title'         => 'Famille :name',
    ],
];
