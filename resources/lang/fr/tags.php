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
        'title'         => 'Nouvelle Etiquette',
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
        'tag'           => 'Etiquette Parentale',
        'tags'          => 'Etiquettes',
        'type'          => 'Type',
    ],
    'helpers'       => [
        'nested'    => 'Ce mode de navigation permet d\'afficher les étiquettes de manière imbriquée. Les étiquettes sans étiquette parent seront affichés par défaut. Les étiquettes possédant des sous-étiquettes peuvent être cliquées pour afficher leurs enfants. Tu peux continuer à cliquer jusqu\'à ce qu\'il n\'y ait plus d\'enfants à voir.',
    ],
    'hints'         => [
        'children'  => 'Cette liste contient toutes les entités directement dans cette étiquette et toutes les étiquettes enfants.',
        'tag'       => 'Affichées ci-dessous sont toutes les étiquettes enfants de cette étiquette.',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Mode Exploration',
        ],
        'add'           => 'Nouvelle Etiquette',
        'description'   => 'Gérer les étiquettes pour :name.',
        'header'        => 'Les étiquettes dans :name',
        'title'         => 'Etiquettes',
    ],
    'new_tag'       => 'Nouvelle Etiquette',
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
            'tags'          => 'Etiquettes',
        ],
        'title'         => 'Etiquette :name',
    ],
    'tags'          => [
        'description'   => 'Enfants d\'étiquette',
        'title'         => 'Etiquette :name',
    ],
];
