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
        'center_marker'     => 'Marqueur',
        'center_x'          => 'Longitude par défaut',
        'center_y'          => 'Latitude par défaut',
        'centering'         => 'Centrage',
        'distance_measure'  => 'Mesure de distance',
        'distance_name'     => 'Unité de distance',
        'grid'              => 'Grille',
        'initial_zoom'      => 'Zoom initial',
        'map'               => 'Carte mère',
        'maps'              => 'Cartes',
        'max_zoom'          => 'Zoom maximal',
        'min_zoom'          => 'Zoom minimal',
        'name'              => 'Nom',
        'tabs'              => [
            'coordinates'   => 'Coordinnées',
            'marker'        => 'Marqueur',
        ],
        'type'              => 'Type',
    ],
    'helpers'       => [
        'center'            => 'Modifier les valeurs par défaut défini le centre de la carte lors de l\'affichage de celle-ci. Ci les champs sont vides, le centre de la carte sera utilisé.',
        'centering'         => 'Centrer la carte sur un marqueur est prioritaire sur les coordinnées.',
        'descendants'       => 'Liste des cartes qui sont groupées dans cette carte.',
        'distance_measure'  => 'Définir une unité de distance activera l\'outil de calcul de distance dans le mode d\'exploration.',
        'grid'              => 'Définir une taille de grille qui s\'affichera dans le mode d\'exploration.',
        'initial_zoom'      => 'Le zoom initial est utilisé pour afficher la carte quand celle-ci est chargée. La valeur par défaut est de :default, la valeur max est de :max et la valeur min est de :min.',
        'max_zoom'          => 'La valeur maximale à laquelle la carte peut être agrandie. La valeur par défaut est de :default, et la valeur maximale est de :max.',
        'min_zoom'          => 'La valeur minimale à laquelle la carte peut être rétrécie. La valeur par défaut est de :default, et la valeur minimale est de :min.',
        'missing_image'     => 'Enregister la carte avec une image avant de pouvoir ajouter des couches et des marqueurs.',
        'nested_parent'     => 'Affichage des cartes de :parent.',
        'nested_without'    => 'Affichage des cartes sans parent. Cliquer sur une rangée pour afficher les cartes enfants.',
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
        'center_marker'     => 'Laisser vide pour afficher au milieu',
        'center_x'          => 'Laisser vide pour afficher au milieu',
        'center_y'          => 'Laisser vide pour afficher au milieu',
        'distance_measure'  => 'Unités par pixel',
        'distance_name'     => 'Nom de l\'unité de distance (kilomètre, mile)',
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
