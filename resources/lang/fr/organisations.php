<?php

return [
    'create'        => [
        'success'   => 'Organisation \':name\' créée.',
        'title'     => 'Nouvelle Organisation',
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
        'type'          => 'Type',
    ],
    'helpers'       => [
        'descendants'   => 'Cette liste contient toutes les organisations qui appartiennent directement ou indirectement à cette organisation.',
        'nested_parent' => 'Affichage des organisations de :parent.',
        'nested_without'=> 'Affichage des organisations sans parent. Cliquer sur une rangées pour afficher les organisations enfants.',
    ],
    'index'         => [
        'title' => 'Organisations',
    ],
    'members'       => [
        'actions'       => [
            'add'   => 'Ajouter un membre',
        ],
        'create'        => [
            'success'   => 'Membre ajouté à l\'organisation :name.',
            'title'     => 'Nouveau membre pour :name',
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
            'parent'        => 'Superieur',
            'pinned'        => 'Épinglé',
            'role'          => 'Rôle',
            'status'        => 'Status de membre',
        ],
        'helpers'       => [
            'all_members'   => 'Tous les personnages qui sont membres de cette organisation et des sous-organisations.',
            'members'       => 'Tous les personnages directement membres de cette organisation.',
            'pinned'        => 'Définir sur le membre doit être affiché dans les épingles des entités associées.',
        ],
        'pinned'        => [
            'both'          => 'Les deux',
            'character'     => 'Personnage',
            'none'          => 'Aucun',
            'organisation'  => 'Organisation',
        ],
        'placeholders'  => [
            'character' => 'Choix du personnage',
            'parent'    => 'Qui est le supérieur de ce membre',
            'role'      => 'Chef, Membre, Prêtre, Maître d\'arme',
        ],
        'status'        => [
            'active'    => 'Membre actif',
            'inactive'  => 'Membre inactif',
            'unknown'   => 'Status inconnu',
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
    'quests'        => [],
    'show'          => [
        'tabs'  => [
            'organisations' => 'Organisations',
        ],
    ],
];
