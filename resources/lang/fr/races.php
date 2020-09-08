<?php

return [
    'characters'    => [
        'description'   => 'Personnages de la race.',
        'title'         => 'Personnages de :name',
    ],
    'create'        => [
        'description'   => 'Créer une nouvelle race',
        'success'       => 'Race \':name\' créée.',
        'title'         => 'Nouvelle Race',
    ],
    'destroy'       => [
        'success'   => 'Race \':name\' supprimée.',
    ],
    'edit'          => [
        'success'   => 'Race \':name\' mise à jour.',
        'title'     => 'Modifier la race :name',
    ],
    'fields'        => [
        'characters'    => 'Personnages',
        'name'          => 'Nom',
        'race'          => 'Race Parentale',
        'races'         => 'Sous-races',
        'type'          => 'Type',
    ],
    'helpers'       => [
        'nested'    => 'Ce mode de navigation permet d\'afficher les races de manière imbriquée. Les races sans race parent seront affichées par défaut. Les races possédant des sous-races peuvent être cliquées pour afficher leurs enfants. Tu peux continuer à cliquer jusqu\'à ce qu\'il n\'y ait plus d\'enfants à voir.',
    ],
    'index'         => [
        'add'           => 'Nouvelle Race',
        'description'   => 'Gestion des races de :name.',
        'header'        => 'Races de :name',
        'title'         => 'Races',
    ],
    'placeholders'  => [
        'name'  => 'Nom de la race',
        'type'  => 'Humain, Fée, Borg',
    ],
    'races'         => [
        'description'   => 'Sous-races de la race.',
        'title'         => 'Sous-races de :name',
    ],
    'show'          => [
        'description'   => 'Détails d\'une race',
        'tabs'          => [
            'characters'    => 'Personnages',
            'menu'          => 'Menu',
            'races'         => 'Sous-races',
        ],
        'title'         => 'Race :name',
    ],
];
