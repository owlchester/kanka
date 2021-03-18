<?php

return [
    'actions'       => [
        'entry' => 'Écrire une entrée personnalisés pour ce marqueur.',
        'remove'=> 'Supprimer le marqueur',
        'update'=> 'Modifier le marqueur',
    ],
    'create'        => [
        'success'   => 'Marqueur :name créé.',
        'title'     => 'Nouveau marqueur',
    ],
    'delete'        => [
        'success'   => 'Marqueur :name supprimé.',
    ],
    'edit'          => [
        'success'   => 'Marqueur :name modifié.',
        'title'     => 'Modifier le marqueur :name',
    ],
    'fields'        => [
        'circle_radius' => 'Radius du cercle',
        'copy_elements' => 'Copier les éléments',
        'custom_icon'   => 'Icône personnalisée',
        'custom_shape'  => 'Forme personnalisée',
        'font_colour'   => 'Couleur d\'icône',
        'group'         => 'Groupe de marqueur',
        'is_draggable'  => 'Déplaçable',
        'latitude'      => 'Latitude',
        'longitude'     => 'Longitude',
        'opacity'       => 'Opacité',
        'pin_size'      => 'Taille du marqueur',
        'polygon_style' => [
            'stroke'            => 'Couleur de la bordure',
            'stroke-opacity'    => 'Opacité de la bordure',
            'stroke-width'      => 'Taille de la bordure',
        ],
    ],
    'helpers'       => [
        'base'                      => 'Ajouter des marqueurs en cliquant sur la carte.',
        'copy_elements'             => 'Copier les groupes, couches, et marqueurs.',
        'copy_elements_to_campaign' => 'Copier les groupes, couches, et marqueurs de la carte. Les marqueurs liés à des entités seront transformés en marqueurs standards.',
        'custom_icon'               => 'Copier le HTML d\'une icône depuis :fontawesome ou :rpgawesome, ou ajouter une icône SVG personnalisée.',
        'custom_radius'             => 'Sélectionner l\'option personnalisée pour définir une taille.',
        'draggable'                 => 'Cocher pour permettre au marqueur d\'être déplacé en mode exploration.',
        'label'                     => 'Un label est affiché comme bloque de texte sur la carte. Le text affiché sera le nom du marqueur ou le nom de l\'entité liée.',
        'polygon'                   => [
            'edit'  => 'Cliquer sur le carte pour ajouter des coordonnées au polygone.',
            'new'   => 'Déplacer le marqueur sur la carte pour ajouter les coordonnées au polygone.',
        ],
    ],
    'icons'         => [
        'custom'        => 'Personnalisé',
        'entity'        => 'Entité',
        'exclamation'   => 'Point d\'exclamation',
        'marker'        => 'Marqueur',
        'question'      => 'Point d\'interrogation',
    ],
    'placeholders'  => [
        'custom_shape'  => '100,100, 200,240, 340,110',
        'name'          => 'Nom du marqueur',
    ],
    'shapes'        => [
        '0' => 'Cercle',
        '1' => 'Carré',
        '2' => 'Triangle',
        '3' => 'Personnalisée',
    ],
    'sizes'         => [
        '0' => 'Minuscule',
        '1' => 'Standard',
        '2' => 'Petit',
        '3' => 'Grand',
        '4' => 'Enorme',
    ],
    'tabs'          => [
        'circle'    => 'Cercle',
        'label'     => 'Label',
        'marker'    => 'Marqueur',
        'polygon'   => 'Polygone',
    ],
];
