<?php

return [
    'characters'    => [
        'description'   => 'Personnages de la race.',
        'helpers'       => [
            'all_characters'    => 'Affichage des personnages de cette race et de toutes les sous-races.',
            'characters'        => 'Affichage de tous les personnages de cette race.',
        ],
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
        'nested_parent' => 'Affichage des races de :parent.',
        'nested_without'=> 'Affichage des races sans parent. Cliquer sur une rangée pour afficher les races enfants.',
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
