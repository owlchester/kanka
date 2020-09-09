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
        'success'   => 'Organisation \':name\' modifiée.',
        'title'     => 'Modifier Organisation :name',
    ],
    'fields'        => [
        'image'         => 'Image',
        'location'      => 'Lieu',
        'members'       => 'Membres',
        'name'          => 'Nom',
        'organisation'  => 'Organisation Parent',
        'organisations' => 'Sous-organisations',
        'relation'      => 'Relation',
        'type'          => 'Type',
    ],
    'helpers'       => [
        'descendants'   => 'Cette liste contient toutes les organisations qui appartiennent directement ou indirectement à cette organisation.',
        'nested'        => 'Ce mode de navigation permet d\'afficher les organisations de manière imbriquée. Les organisations sans organisation parent seront affichées par défaut. Les organisations possédant des sous-organisations peuvent être cliquées pour afficher leurs enfants. Tu peux continuer à cliquer jusqu\'à ce qu\'il n\'y ait plus d\'enfants à voir.',
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
            'success'   => 'Membre modifié.',
            'title'     => 'Modifier Membre pour :name',
        ],
        'fields'        => [
            'character'     => 'Personnage',
            'organisation'  => 'Organisation',
            'role'          => 'Rôle',
        ],
        'helpers'       => [
            'all_members'   => 'Tous les personnages qui sont membres de cette organisation et des sous-organisations.',
            'members'       => 'Tous les personnages directement membres de cette organisation.',
        ],
        'placeholders'  => [
            'character' => 'Choix du personnage',
            'role'      => 'Chef, Membre, Prêtre, Maître d\'arme',
        ],
        'title'         => 'Organisation :name Membres',
    ],
    'organisations' => [
        'title' => 'Organisation :name Organisations',
    ],
    'placeholders'  => [
        'location'  => 'Choix du lieu',
        'name'      => 'Nom de l\'organisation',
        'type'      => 'Culte, Bande, Rebellion',
    ],
    'quests'        => [
        'description'   => 'Quêtes dont l\'organisation fait partie.',
        'title'         => 'Organisation :name Quêtes',
    ],
    'show'          => [
        'description'   => 'Détail de l\'organisation',
        'tabs'          => [
            'organisations' => 'Organisations',
            'quests'        => 'Quêtes',
            'relations'     => 'Relations',
        ],
        'title'         => 'Organisation :name',
    ],
];
