<?php

return [
    'create'        => [
        'description'   => 'Créer une nouvelle organisation',
        'success'       => 'Organisation \':name\' créée.',
        'title'         => 'Nouvelle Organisation',
    ],
    'destroy'       => [
        'success'   => 'Organisation \':name\' supprimée.',
    ],
    'edit'          => [
        'description'   => '',
        'success'       => 'Organisation \':name\' modifiée.',
        'title'         => 'Modifier Organisation :name',
    ],
    'fields'        => [
        'history'   => 'Histoire',
        'image'     => 'Image',
        'location'  => 'Lieu',
        'members'   => 'Membres',
        'name'      => 'Nom',
        'relation'  => 'Relation',
        'type'      => 'Type',
    ],
    'index'         => [
        'add'           => 'Nouvelle Organisation',
        'description'   => 'Gérer les organisation de :name.',
        'header'        => 'Organisations de :name',
        'title'         => 'Organisations',
    ],
    'members'       => [
        'actions'       => [
            'add'   => 'Ajouter un membre',
        ],
        'create'        => [
            'description'   => 'Ajouter un membre à l\'organisation',
            'success'       => 'Membre ajouté à l\'organisation :name.',
            'title'         => 'Nouveau membre pour :name',
        ],
        'destroy'       => [
            'success'   => 'Membre retiré de l\'organisation',
        ],
        'edit'          => [
            'description'   => '',
            'success'       => 'Membre modifié.',
            'title'         => 'Modifier Member pour :name',
        ],
        'fields'        => [
            'character' => 'Personnage',
            'role'      => 'Rôle',
        ],
        'hint'          => 'Les organisations ont généralement besoin de membre pour fonctionner correctement.',
        'placeholders'  => [
            'character' => 'Choix du personnage',
            'role'      => 'Chef, Membre, Prêtre, Maître d\'arme',
        ],
    ],
    'placeholders'  => [
        'location'  => 'Choix du lieu',
        'name'      => 'Nom de l\'organisation',
        'type'      => 'Culte, Bande, Rebellion',
    ],
    'show'          => [
        'description'   => 'Détail de l\'organisation',
        'tabs'          => [
            'history'   => 'Histoire',
            'members'   => 'Membres',
            'relations' => 'Relations',
        ],
        'title'         => 'Organisation :name',
    ],
];
