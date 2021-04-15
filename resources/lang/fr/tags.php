<?php

return [
    'children'      => [
        'actions'       => [
            'add'   => 'Ajouter une nouvelle étiquette',
        ],
        'create'        => [
            'title' => 'Ajouter une nouvelle étiquette pour :name',
        ],
        'description'   => 'Entités appartenant à l\'étiquette',
        'title'         => 'Enfants de l\'étiquette :name',
    ],
    'create'        => [
        'description'   => 'Ajouter une nouvelle étiquette',
        'success'       => 'Nouvelle étiquette \':name\' ajoutée.',
        'title'         => 'Nouvelle étiquette',
    ],
    'destroy'       => [
        'success'   => 'L\'étiquette \':name\' a été retirée.',
    ],
    'edit'          => [
        'success'   => 'L\'étiquette \':name\' a été mise à jour.',
        'title'     => 'Modifier l\'étiquette :name',
    ],
    'fields'        => [
        'characters'    => 'Personnages',
        'children'      => 'Enfants',
        'name'          => 'Nom',
        'tag'           => 'Étiquette Parentale',
        'tags'          => 'Étiquettes',
        'type'          => 'Type',
    ],
    'helpers'       => [
        'nested_parent' => 'Affichage des étiquettes de :parent.',
        'nested_without'=> 'Affichage des étiquettes sans parent. Cliquer sur une rangée pour afficher les étiquettes enfants.',
    ],
    'hints'         => [
        'children'  => 'Cette liste contient toutes les entités directement dans cette étiquette et toutes les étiquettes enfants.',
        'tag'       => 'Affichées ci-dessous sont toutes les étiquettes enfants de cette étiquette.',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Mode Exploration',
        ],
        'add'           => 'Nouvelle étiquette',
        'description'   => 'Gérer les étiquettes pour :name.',
        'header'        => 'Les étiquettes dans :name',
        'title'         => 'Étiquettes',
    ],
    'new_tag'       => 'Nouvelle étiquette',
    'placeholders'  => [
        'name'  => 'Nom de l\'étiquette',
        'tag'   => 'Choix de l\'étiquette parent',
        'type'  => 'Légende, Guerres, Histoire, Religion',
    ],
    'show'          => [
        'description'   => 'Vue détaillée de l\'étiquette',
        'tabs'          => [
            'children'      => 'Enfants',
            'information'   => 'Information',
            'tags'          => 'Étiquettes',
        ],
        'title'         => 'Étiquette :name',
    ],
    'tags'          => [
        'description'   => 'Enfants d\'étiquette',
        'title'         => 'Étiquette :name',
    ],
];
