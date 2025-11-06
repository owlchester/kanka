<?php

return [
    'actions'       => [
        'entry'             => 'Écrire une entrée personnalisés pour ce marqueur.',
        'remove'            => 'Supprimer le marqueur',
        'reset-polygon'     => 'Réinitialiser les positions',
        'save_and_explore'  => 'Sauvegarder et explorer',
        'start-drawing'     => 'Commencer à dessiner',
        'update'            => 'Modifier le marqueur',
    ],
    'bulks'         => [
        'delete'    => '{1} Retiré :count marqueur.|[2,*] Retiré :count marqueurs.',
        'patch'     => '{1} Modifié :count marqueur.|[2,*] Modifié :count marqueurs.',
    ],
    'circle_sizes'  => [
        'custom'    => 'Personnalisé',
        'huge'      => 'Énorme',
        'large'     => 'Grand',
        'small'     => 'Petit',
        'standard'  => 'Moyen',
        'tiny'      => 'Minuscule',
    ],
    'create'        => [
        'success'   => 'Marqueur :name créé.',
        'title'     => 'Nouveau marqueur',
    ],
    'delete'        => [
        'success'   => 'Marqueur :name supprimé.',
    ],
    'details'       => [
        'from-entity'   => 'De l\'entité',
    ],
    'edit'          => [
        'success'   => 'Marqueur :name modifié.',
        'title'     => 'Modifier le marqueur :name',
    ],
    'fields'        => [
        'bg_colour'     => 'Couleur de fond',
        'circle_radius' => 'Radius du cercle',
        'copy_elements' => 'Copier les éléments',
        'custom_icon'   => 'Icône personnalisée',
        'custom_shape'  => 'Forme personnalisée',
        'font_colour'   => 'Couleur d\'icône',
        'group'         => 'Groupe de marqueur',
        'icon'          => 'Icône',
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
        'popupless'     => 'Infobulle',
        'size'          => 'Taille',
    ],
    'helpers'       => [
        'base'                      => 'Ajouter des marqueurs en cliquant sur la carte.',
        'copy_elements'             => 'Copier les groupes, couches, et marqueurs.',
        'copy_elements_to_campaign' => 'Copier les groupes, couches, et marqueurs de la carte. Les marqueurs liés à des entités seront transformés en marqueurs standards.',
        'css'                       => 'Définir une class CSS personnalisés pour le marqueur.',
        'custom_icon_v2'            => 'Utilises des icônes de :fontawesome, :rpgawesome, ou avec un SVG personalisé. Découvres comment dans notre :docs.',
        'custom_radius'             => 'Sélectionner l\'option personnalisée pour définir une taille.',
        'draggable'                 => 'Cocher pour permettre au marqueur d\'être déplacé en mode exploration.',
        'is_popupless'              => 'Désactiver l\'infobulle lors du survol du marqueur.',
        'label'                     => 'Un label est affiché comme bloque de texte sur la carte. Le text affiché sera le nom du marqueur ou le nom de l\'entité liée.',
        'polygon'                   => [
            'edit'  => 'Cliquer sur le carte pour ajouter des coordonnées au polygone.',
        ],
    ],
    'hints'         => [
        'entry' => 'Modifier le marqueur pour y écrire une entrée personnalisée.',
    ],
    'icons'         => [
        'custom'        => 'Personnalisé',
        'entity'        => 'Entité',
        'exclamation'   => 'Point d\'exclamation',
        'marker'        => 'Marqueur',
        'question'      => 'Point d\'interrogation',
    ],
    'index'         => [
        'title' => 'Marqueurs de :name',
    ],
    'pitches'       => [
        'poly'  => 'Dessines des formes polygonales personnalisées pour représenter les bordures et autres formes inégales.',
    ],
    'placeholders'  => [
        'custom_icon'   => 'Essaie :example1 ou :example2',
        'custom_shape'  => '100,100, 200,240, 340,110',
        'name'          => 'Nom du marqueur',
    ],
    'presets'       => [
        'helper'    => 'Cliques sur un préréglage pour le charger, ou crées-en un nouveau.',
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
        'preset'    => 'Préréglage',
    ],
];
