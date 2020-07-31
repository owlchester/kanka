<?php

return [
    'actions'       => [
        'back'      => 'Retour à :name',
        'edit'      => 'Modifier la carte',
        'explore'   => 'Explorer',
    ],
    'create'        => [
        'success'   => 'Carte :name créée.',
        'title'     => 'Nouvelle carte',
    ],
    'edit'          => [
        'success'   => 'Carte :name modifiée.',
        'title'     => 'Modifier la carte :name',
    ],
    'errors'        => [
        'explore'   => [
            'missing'   => 'Il faut ajouter une image à la carte avant de pouvoir l\'explorer.',
        ],
    ],
    'fields'        => [
        'distance_measure'  => 'Mesure de distance',
        'distance_name'     => 'Unité de distance',
        'grid'              => 'Grille',
        'map'               => 'Carte mère',
        'maps'              => 'Cartes',
        'name'              => 'Nom',
        'type'              => 'Type',
    ],
    'helpers'       => [
        'descendants'       => 'Liste des cartes qui sont groupées dans cette carte.',
        'distance_measure'  => 'Définir une unité de distance activera l\'outil de calcul de distance dans le mode d\'exploration.',
        'grid'              => 'Définir une taille de grille qui s\'affichera dans le mode d\'exploration.',
        'missing_image'     => 'Enregister la carte avec une image avant de pouvoir ajouter des couches et des marqueurs.',
        'nested'            => 'Ce mode de navigation permet d\'afficher les cartes de manière imbriquées. Les cartes sans carte parent seront affichées par défaut. Les cartes possédant des sous-cartes peuvent être cliquées pour afficher ces enfants. Tu peux continuer à cliquer jusqu\'à ce qu\'il n\'y ait plus d\'enfants à voir.',
    ],
    'index'         => [
        'add'   => 'Nouvelle carte',
        'title' => 'Cartes',
    ],
    'maps'          => [
        'title' => 'Cartes de :name',
    ],
    'panels'        => [
        'groups'    => 'Groupes',
        'layers'    => 'Couches',
        'markers'   => 'Marqueurs',
        'settings'  => 'Paramètres',
    ],
    'placeholders'  => [
        'distance_measure'  => 'Unités par pixel',
        'distance_name'     => 'Nom de l\'unité de distance (kilometre, mile)',
        'grid'              => 'Distance entre les éléments de la grille. Laisser vide pour cacher la grille.',
        'name'              => 'Nom de la carte',
        'type'              => 'Donjon, Ville, Univers',
    ],
    'show'          => [
        'tabs'  => [
            'maps'  => 'Cartes',
        ],
        'title' => 'Carte :name',
    ],
];
