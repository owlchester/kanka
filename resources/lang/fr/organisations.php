<?php

return [
    'create'        => [
        'title' => 'Nouvelle Organisation',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'image'         => 'Image',
        'is_defunct'    => 'Défunte',
        'location'      => 'Lieu',
        'members'       => 'Membres',
        'name'          => 'Nom',
        'organisation'  => 'Organisation Parent',
        'organisations' => 'Sous-organisations',
        'type'          => 'Type',
    ],
    'helpers'       => [
        'descendants'       => 'Cette liste contient toutes les organisations qui appartiennent directement ou indirectement à cette organisation.',
        'nested_without'    => 'Affichage des organisations sans parent. Cliquer sur une rangées pour afficher les organisations enfants.',
    ],
    'hints'         => [
        'is_defunct'    => 'Cette organisation n\'est plus en opération.',
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
