<?php

return [
    'characters'    => [
        'create'    => [
            'description'   => 'Lier un personnage à la quête',
            'success'       => 'Personnage ajouté à :name.',
            'title'         => 'Nouveau personnage pour :name',
        ],
        'destroy'   => [
            'success'   => 'Personnage pour :name supprimé.',
        ],
        'edit'      => [
            'description'   => '',
            'success'       => 'Personnage pour :name modifié.',
            'title'         => 'Modifier un personnage pour :name',
        ],
        'fields'    => [
            'character'     => 'Personnage',
            'description'   => 'Description',
        ],
    ],
    'create'        => [
        'description'   => '',
        'success'       => 'Quête \':name\' créée.',
        'title'         => 'Ajouter une quête',
    ],
    'destroy'       => [
        'success'   => 'Quête \':name\' supprimée.',
    ],
    'edit'          => [
        'description'   => '',
        'success'       => 'Quête \':name\' modifiée.',
        'title'         => 'Modifier Quête :name',
    ],
    'fields'        => [
        'characters'    => 'Personnages',
        'description'   => 'Description',
        'image'         => 'Image',
        'locations'     => 'Lieux',
        'name'          => 'Nom',
        'type'          => 'Type',
    ],
    'index'         => [
        'add'           => 'Nouvelle Quête',
        'description'   => 'Gérer les quêtes de :name.',
        'header'        => 'Quêtes de :name',
        'title'         => 'Quêtes',
    ],
    'locations'     => [
        'create'    => [
            'description'   => 'Lier un lieu à la quête',
            'success'       => 'Lieu ajouté à :name.',
            'title'         => 'Nouveau lieu pour :name',
        ],
        'destroy'   => [
            'success'   => 'Lieu pour :name supprimé.',
        ],
        'edit'      => [
            'description'   => '',
            'success'       => 'Lieu pour :name modifié.',
            'title'         => 'Modifier lieu pour :name',
        ],
        'fields'    => [
            'description'   => 'Description',
            'location'      => 'Lieu',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Nom de la quête',
        'type'  => 'Principale, side quest, personnage',
    ],
    'show'          => [
        'actions'       => [
            'add_character' => 'Ajouter un personnage',
            'add_location'  => 'Ajouter un lieu',
        ],
        'description'   => 'Détail de la quête',
        'tabs'          => [
            'characters'    => 'Personnages',
            'information'   => 'Information',
            'locations'     => 'Lieux',
        ],
        'title'         => 'Quête :name',
    ],
];
