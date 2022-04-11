<?php

return [
    'children'      => [
        'actions'   => [
            'add'   => 'Ajouter une nouvelle étiquette',
        ],
        'create'    => [
            'success'   => 'L\'étiquette :name a été ajoutée à l\'entité.',
            'title'     => 'Ajouter une nouvelle étiquette pour :name',
        ],
        'title'     => 'Enfants de l\'étiquette :name',
    ],
    'create'        => [
        'success'   => 'Nouvelle étiquette \':name\' ajoutée.',
        'title'     => 'Nouvelle étiquette',
    ],
    'destroy'       => [
        'success'   => 'L\'étiquette \':name\' a été retirée.',
    ],
    'edit'          => [
        'success'   => 'L\'étiquette \':name\' a été mise à jour.',
        'title'     => 'Modifier l\'étiquette :name',
    ],
    'fields'        => [
        'children'  => 'Enfants',
        'name'      => 'Nom',
        'tag'       => 'Étiquette Parentale',
        'tags'      => 'Étiquettes',
        'type'      => 'Type',
    ],
    'helpers'       => [
        'nested_parent' => 'Affichage des étiquettes de :parent.',
        'nested_without'=> 'Affichage des étiquettes sans parent. Cliquer sur une rangée pour afficher les étiquettes enfants.',
        'no_children'   => 'Il n\'y a actuellement aucune entité avec cette étiquette.',
    ],
    'hints'         => [
        'children'  => 'Cette liste contient toutes les entités directement dans cette étiquette et toutes les étiquettes enfants.',
        'tag'       => 'Affichées ci-dessous sont toutes les étiquettes enfants de cette étiquette.',
    ],
    'index'         => [
        'actions'   => [
            'explore_view'  => 'Mode Exploration',
        ],
        'add'       => 'Nouvelle étiquette',
        'header'    => 'Les étiquettes dans :name',
        'title'     => 'Étiquettes',
    ],
    'new_tag'       => 'Nouvelle étiquette',
    'placeholders'  => [
        'name'  => 'Nom de l\'étiquette',
        'tag'   => 'Choix de l\'étiquette parent',
        'type'  => 'Légende, Guerres, Histoire, Religion',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Enfants',
            'tags'      => 'Étiquettes',
        ],
        'title' => 'Étiquette :name',
    ],
    'tags'          => [
        'title' => 'Étiquette :name',
    ],
];
