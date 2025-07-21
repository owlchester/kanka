<?php

return [
    'create'        => [
        'template'  => [
            'helper'    => 'Les administrateurs de la campagne ont défini les articles suivants comme des modèles pouvant être réutilisés.',
        ],
        'title'     => 'Nouvel article',
    ],
    'fields'        => [
        'name'  => 'Nom',
    ],
    'helpers'       => [
        'new'           => 'Ajouter un nouvel article à cette entité.',
        'visibility'    => 'Modifier la visibilité de l\'article :name.',
    ],
    'move'          => [
        'copy'      => [
            'helper'    => 'Garder une copie de l\'article sur :name.',
        ],
        'helper'    => 'Déplacer ou copier l\'article :name vers une autre entité.',
        'title'     => 'Déplacer l\'article',
    ],
    'permissions'   => [
        'actions'   => [
            'members'   => 'Ajouter des membres',
            'roles'     => 'Ajouter des rôles',
        ],
        'helpers'   => [
            'members'   => 'Ajouter un ou plusieurs membres qui auront des permissions spéciales sur l\'article.',
            'roles'     => 'Ajouter un ou plusieurs rôles qui auront des permissions spéciales sur l\'article.',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Nom de l\'article',
    ],
    'position'      => [
        'dont_change'   => 'Tel quel',
        'first'         => 'Premier',
        'last'          => 'Dernier',
    ],
    'remove'        => [
        'title' => 'Supprimer l\'article',
    ],
    'visibility'    => [
        'helper'    => 'Modifier la visibilité de l\'article :name.',
        'title'     => 'Visibilité de l\'article',
    ],
];
