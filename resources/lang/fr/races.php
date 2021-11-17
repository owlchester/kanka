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
        'success'   => 'Race \':name\' créée.',
        'title'     => 'Nouvelle Race',
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
        'add'       => 'Nouvelle Race',
        'header'    => 'Races de :name',
        'title'     => 'Races',
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
        'title' => 'Race :name',
    ],
];
