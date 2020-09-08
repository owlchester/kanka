<?php

return [
    'create'        => [
        'description'   => 'Créer une nouvelle famille',
        'success'       => 'Famille \':name\' ajoutée.',
        'title'         => 'Nouvelle Famille',
    ],
    'destroy'       => [
        'success'   => 'Famille \':name\' supprimée.',
    ],
    'edit'          => [
        'success'   => 'Famille \':name\' modifiée.',
        'title'     => 'Modifier la famille :name',
    ],
    'families'      => [
        'title' => 'Familles de la famille :name',
    ],
    'fields'        => [
        'families'  => 'Sous-familles',
        'family'    => 'Famille Parent',
        'image'     => 'Image',
        'location'  => 'Lieu',
        'members'   => 'Membres',
        'name'      => 'Nom',
        'relation'  => 'Relation',
        'type'      => 'Type',
    ],
    'helpers'       => [
        'descendants'   => 'Cette liste contient toutes les familles qui sont des descendants de cette famille, et pas seulement celles directement sous celle-ci.',
        'nested'        => 'Ce mode de navigation permet d\'afficher les familles de manière imbriquée. Les familles sans famille parent seront affichées par défaut. Les familles possédant des sous-familles peuvent être cliquées pour afficher leurs enfants. Tu peux continuer à cliquer jusqu\'à ce qu\'il n\'y ait plus d\'enfants à voir.',
    ],
    'hints'         => [
        'members'   => 'Les membres d\'une famille sont affichés ici. Un personnage peut être ajouté à une famille lors de l\'édition du personnage en utilisant le champ "Famille".',
    ],
    'index'         => [
        'add'           => 'Nouvelle Famille',
        'description'   => 'Gérer les familles de :name.',
        'header'        => 'Familles de :name',
        'title'         => 'Familles',
    ],
    'members'       => [
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
        'description'   => 'Détail d\'une famille',
        'tabs'          => [
            'all_members'   => 'Tous les membres',
            'families'      => 'Familles',
            'members'       => 'Membres',
            'relation'      => 'Relations',
        ],
        'title'         => 'Famille :name',
    ],
];
