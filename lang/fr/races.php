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
        'members'       => 'Membres',
        'race'          => 'Race Parentale',
        'races'         => 'Sous-races',
    ],
    'helpers'       => [
        'nested_without'    => 'Affichage des races sans parent. Cliquer sur une rangée pour afficher les races enfants.',
    ],
    'index'         => [],
    'members'       => [
        'create'    => [
            'submit'    => 'Ajouter membres',
            'success'   => '{0} Aucun membre ajouté.|{1} 1 membre ajouté.|[2,*] :count membres ajoutés.',
            'title'     => 'Nouveaux membres',
        ],
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
