<?php

return [
    'actions'       => [
        'back'      => 'Retour à :name',
        'edit'      => 'Modifier la carte',
        'explore'   => 'Explorer',
    ],
    'create'        => [
        'title' => 'Nouvelle carte',
    ],
    'errors'        => [
        'chunking'  => [
            'error'     => 'Une erreur est survenue durant le traitement de la carte. Contactes l\'équipe sur :discord pour de l\'aide.',
            'running'   => [
                'edit'      => 'La carte ne peut pas être modifiée pendant qu\'elle est en traitement.',
                'explore'   => 'La carte ne peut pas être affichée pendant qu\'elle est en traitement.',
                'time'      => 'Ceci peut prendre plusieurs minutes à plusieurs heures et dépend de la taille de la carte.',
            ],
        ],
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
        'has_clustering'    => 'Grouper les marqueurs',
        'initial_zoom'      => 'Zoom initial',
        'is_real'           => 'Utiliser OpenStreetMaps',
        'max_zoom'          => 'Zoom maximal',
        'min_zoom'          => 'Zoom minimal',
        'tabs'              => [
            'coordinates'   => 'Coordonnées',
            'marker'        => 'Marqueur',
        ],
    ],
    'helpers'       => [
        'center'                => 'Modifier les valeurs par défaut défini le centre de la carte lors de l\'affichage de celle-ci. Ci les champs sont vides, le centre de la carte sera utilisé.',
        'centering'             => 'Centrer la carte sur un marqueur est prioritaire sur les coordinnées.',
        'chunked_zoom'          => 'Les cartes fragmentées ont leurs paramètres minimum et maximum définis par le processus de segmentation.',
        'distance_measure'      => 'Définir une unité de distance activera l\'outil de calcul de distance dans le mode d\'exploration.',
        'distance_measure_2'    => 'Pour que 100 pixels mesurent 1 kilomètre, choisir une valeur de 0.0041.',
        'grid'                  => 'Définir une taille de grille qui s\'affichera dans le mode d\'exploration.',
        'has_clustering'        => 'Regrouper automatiquement les marqueurs lorsqu\'ils sont proches les uns des autres.',
        'initial_zoom'          => 'Le zoom initial est utilisé pour afficher la carte quand celle-ci est chargée. La valeur par défaut est de :default, la valeur max est de :max et la valeur min est de :min.',
        'is_real'               => 'Sélectionner cette option utilisera les données d\'OpenStreetMaps pour afficher le monde réel au lieu de l\'image téléchargée. Cette option désactive les couches.',
        'max_zoom'              => 'La valeur maximale à laquelle la carte peut être agrandie. La valeur par défaut est de :default, et la valeur maximale est de :max.',
        'min_zoom'              => 'La valeur minimale à laquelle la carte peut être rétrécie. La valeur par défaut est de :default, et la valeur minimale est de :min.',
        'missing_image'         => 'Enregister la carte avec une image avant de pouvoir ajouter des couches et des marqueurs.',
    ],
    'lists'         => [
        'empty' => 'Télécharge une carte pour visualiser les lieux et explorer la géographie de ton monde.',
    ],
    'panels'        => [
        'groups'    => 'Groupes',
        'layers'    => 'Couches',
        'legend'    => 'Légende',
        'markers'   => 'Marqueurs',
        'settings'  => 'Paramètres',
    ],
    'placeholders'  => [
        'center_marker' => 'Laisser vide pour afficher au milieu',
        'center_x'      => 'Laisser vide pour afficher au milieu',
        'center_y'      => 'Laisser vide pour afficher au milieu',
        'distance_name' => 'Km, miles, pieds, hamburgers',
        'grid'          => 'Distance entre les éléments de la grille. Laisser vide pour cacher la grille.',
        'name'          => 'Nom de la carte',
        'type'          => 'Donjon, Ville, Univers',
    ],
    'show'          => [
        'tabs'  => [
            'maps'  => 'Cartes',
        ],
    ],
    'tooltips'      => [
        'chunking'  => [
            'running'   => 'La cartes est en traitement. Ce processus peut prendre plusieurs minutes à plusieurs heures.',
        ],
    ],
];
