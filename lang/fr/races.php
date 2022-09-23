<?php

return [
    'characters'    => [
        'helpers'   => [
            'all_characters'    => 'Affichage des personnages de cette race et de toutes les sous-races.',
            'characters'        => 'Affichage de tous les personnages de cette race.',
        ],
        'title'     => 'Personnages de :name',
    ],
    'create'        => [
        'title' => 'Nouvelle Race',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'characters'    => 'Personnages',
        'locations'     => 'Lieux',
        'name'          => 'Nom',
        'race'          => 'Race Parentale',
        'races'         => 'Sous-races',
        'type'          => 'Type',
    ],
    'helpers'       => [
        'nested_without'    => 'Affichage des races sans parent. Cliquer sur une rangée pour afficher les races enfants.',
    ],
    'index'         => [
        'title' => 'Races',
    ],
    'placeholders'  => [
        'name'  => 'Nom de la race',
        'type'  => 'Humain, Fée, Borg',
    ],
    'races'         => [
        'title' => 'Sous-races de :name',
    ],
    'show'          => [
        'tabs'  => [
            'characters'    => 'Personnages',
            'races'         => 'Sous-races',
        ],
    ],
];
