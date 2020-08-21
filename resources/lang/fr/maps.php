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
    'destroy'       => [
        'success'   => 'Carte :name supprimée.',
    ],
    'edit'          => [
        'success'   => 'Carte :name modifiée.',
        'title'     => 'Modifier la carte :name',
    ],
    'errors'        => [
        'dashboard' => [
            'missing'   => 'La carte a besoin d\'une image pour être affichée sur le tableau de bord.',
        ],
        'explore'   => [
            'missing'   => 'Il faut ajouter une image à la carte avant de pouvoir l\'explorer.',
        ],
    ],
    'fields'        => [
        'distance_measure'  => 'Mesure de distance',
        'distance_name'     => 'Unité de distance',
        'grid'              => 'Grille',
        'initial_zoom'      => 'Zoom initial',
        'map'               => 'Carte mère',
        'maps'              => 'Cartes',
        'max_zoom'          => 'Zoom maximal',
        'min_zoom'          => 'Zoom minimal',
        'name'              => 'Nom',
        'type'              => 'Type',
    ],
    'helpers'       => [
        'descendants'       => 'Liste des cartes qui sont groupées dans cette carte.',
        'distance_measure'  => 'Définir une unité de distance activera l\'outil de calcul de distance dans le mode d\'exploration.',
        'grid'              => 'Définir une taille de grille qui s\'affichera dans le mode d\'exploration.',
        'initial_zoom'      => 'Le zoom initial est utilisé pour afficher la carte quand celle-ci est chargée. La valeur par défaut est de :default, la valeur max est de :max et la valeur min est de :min.',
        'max_zoom'          => 'La valeur maximale à laquelle la carte peut être agrandie. La valeur par défaut est de :default, et la valeur maximale est de :max.',
        'min_zoom'          => 'La valeur minimal à laquelle la carte peut être rétrécie. La valeur par défaut est de :default, et la valeur minimale est de :min.',
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
