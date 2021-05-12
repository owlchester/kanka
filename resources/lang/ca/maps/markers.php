<?php

return [
    'actions'       => [
        'entry'             => 'Escriviu una entrada personalitzada per aquest marcador.',
        'remove'            => 'Elimina el marcador',
        'save_and_explore'  => 'Guarda i explora',
        'update'            => 'Edita el marcador',
    ],
    'create'        => [
        'success'   => 'S\'ha creat el marcador «:name».',
        'title'     => 'Nou marcador',
    ],
    'delete'        => [
        'success'   => 'S\'ha eliminat el marcador «:name».',
    ],
    'edit'          => [
        'success'   => 'S\'ha actualitzat el marcador «:name».',
        'title'     => 'Edita el marcador :name',
    ],
    'fields'        => [
        'circle_radius' => 'Radi circular',
        'copy_elements' => 'Copia els elements',
        'custom_icon'   => 'Icona personalitzada',
        'custom_shape'  => 'Forma personalitzada',
        'font_colour'   => 'Color de la icona',
        'group'         => 'Grup de marcadors',
        'is_draggable'  => 'És arrossegable',
        'latitude'      => 'Latitud',
        'longitude'     => 'Longitud',
        'opacity'       => 'Opacitat',
        'pin_size'      => 'Tamany del marcador',
        'polygon_style' => [
            'stroke'            => 'Color del traç',
            'stroke-opacity'    => 'Opacitat del traç',
            'stroke-width'      => 'Gruix del traç',
        ],
    ],
    'helpers'       => [
        'base'                      => 'Afegiu marcadors al mapa fent clic a qualsevol lloc.',
        'copy_elements'             => 'Copia grups, capes i marcadors.',
        'copy_elements_to_campaign' => 'Copia grups, capes i marcadors dels mapes. Els marcadors vinculats a una entitat es convertiran en marcadors estàndard.',
        'custom_icon'               => 'Copieu l\'HTML d\'una icona de :fontawesome o :rpgawesome, o una icona SVG personalitzada.',
        'custom_radius'             => 'Seleccioneu l\'opció de tamany personalitzat al desplegable per a definir un tamany.',
        'draggable'                 => 'Permet moure els marcadors al mode d\'exploració.',
        'label'                     => 'Una etiqueta es mostra com un bloc de text al mapa. El seu contingut serà el nom del marcador.',
        'polygon'                   => [
            'edit'  => 'Cliqueu al mapa per a afegir-ne la posició a les coordenades del polígon.',
            'new'   => 'Moveu el marcador pel mapa per a guardar-ne la posició al polígon.',
        ],
    ],
    'icons'         => [
        'custom'        => 'Personalitzada',
        'entity'        => 'Entitat',
        'exclamation'   => 'Exclamació',
        'marker'        => 'Marcador',
        'question'      => 'Interrogació',
    ],
    'placeholders'  => [
        'custom_shape'  => '100, 100 200, 240 340, 110',
        'name'          => 'Requerit si no hi ha cap entitat seleccionada',
    ],
    'shapes'        => [
        '0' => 'Cercle',
        '1' => 'Quadrat',
        '2' => 'Triangle',
        '3' => 'Personalitzada',
    ],
    'sizes'         => [
        '0' => 'Minúscul',
        '1' => 'Estàndard',
        '2' => 'Petit',
        '3' => 'Gran',
        '4' => 'Enorme',
    ],
    'tabs'          => [
        'circle'    => 'Cercle',
        'label'     => 'Etiqueta',
        'marker'    => 'Marcador',
        'polygon'   => 'Polígon',
    ],
];
