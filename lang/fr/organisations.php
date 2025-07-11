<?php

return [
    'create'        => [
        'title' => 'Nouvelle Organisation',
    ],
    'fields'        => [
        'is_defunct'    => 'Défunte',
        'members'       => 'Membres',
    ],
    'hints'         => [
        'is_defunct'    => 'Cette organisation n\'est plus en opération.',
    ],
    'members'       => [
        'actions'       => [
            'add'           => 'Ajouter un membre',
            'add_multiple'  => 'Ajouter des membres',
        ],
        'create'        => [
            'helper'            => 'Ajouter un ou plusieurs membres à :name.',
            'success_multiple'  => '{1} Ajouté :count membre à :name.|[2,*] Ajouté :count membres à :name.',
            'title_multiple'    => 'Nouveaux membres',
        ],
        'destroy'       => [
            'success'   => 'Membre retiré de l\'organisation',
        ],
        'edit'          => [
            'helper'    => 'Change le status de membre pour :name.',
            'success'   => 'Membre modifié.',
            'title'     => 'Modifier Membre pour :name',
        ],
        'fields'        => [
            'parent'    => 'Superieur',
            'pinned'    => 'Épinglé',
            'role'      => 'Rôle',
            'status'    => 'Status de membre',
        ],
        'helpers'       => [
            'all_members'   => 'Tous les personnages qui sont membres de cette organisation et des sous-organisations.',
            'members'       => 'Tous les personnages directement membres de cette organisation.',
            'pinned'        => 'Définir sur le membre doit être affiché dans les épingles des entités associées.',
        ],
        'pinned'        => [
            'both'  => 'Les deux',
            'none'  => 'Aucun',
        ],
        'placeholders'  => [
            'parent'    => 'Qui est le supérieur de ce membre',
            'role'      => 'Chef, Membre, Prêtre, Maître d\'arme',
        ],
        'status'        => [
            'active'    => 'Membre actif',
            'inactive'  => 'Membre inactif',
            'unknown'   => 'Status inconnu',
        ],
    ],
    'placeholders'  => [
        'type'  => 'Culte, Bande, Rebellion',
    ],
];
