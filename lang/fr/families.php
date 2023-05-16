<?php

return [
    'create'        => [
        'title' => 'Nouvelle Famille',
    ],
    'destroy'       => [],
    'edit'          => [],
    'families'      => [
        'title' => 'Familles de la famille :name',
    ],
    'fields'        => [
        'families'  => 'Sous-familles',
        'family'    => 'Famille Parent',
        'members'   => 'Membres',
    ],
    'helpers'       => [
        'descendants'       => 'Cette liste contient toutes les familles qui sont des descendants de cette famille, et pas seulement celles directement sous celle-ci.',
        'nested_without'    => 'Affichage des familles sans parent. Cliquer sur une rangée pour afficher les familles enfants.',
    ],
    'hints'         => [
        'members'   => 'Les membres d\'une famille sont affichés ici. Un personnage peut être ajouté à une famille lors de l\'édition du personnage en utilisant le champ "Famille".',
    ],
    'index'         => [],
    'members'       => [
        'create'    => [
            'submit'    => 'Ajouter membres',
            'success'   => '{0} Aucun membre ajouté.|{1} 1 membre ajouté.|[2,*] :count membres ajoutés.',
            'title'     => 'Nouveau membres',
        ],
        'helpers'   => [
            'all_members'       => 'Cette liste contient tous les personnages qui sont dans cette famille et toutes ses sous-familles.',
            'direct_members'    => 'Cette liste contient tous les membres directement dans cette famille.',
        ],
        'title'     => 'Membres de la famille :name',
    ],
    'placeholders'  => [
        'location'  => 'Choix d\'un lieu',
        'name'      => 'Nom de la famille',
        'type'      => 'Royale, Noble, Éteinte',
    ],
    'show'          => [
        'tabs'  => [
            'all_members'   => 'Tous les membres',
            'families'      => 'Familles',
            'members'       => 'Membres',
            'tree'          => 'Arbre de famille',
        ],
    ],
];
