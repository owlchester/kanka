<?php

return [
    'actions'       => [
        'remove'    => 'Elimina el marcador',
        'update'    => 'Edita el marcador',
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
        'custom_icon'   => 'Icona personalitzada',
        'custom_shape'  => 'Forma personalitzada',
        'font_colour'   => 'Color de la icona',
        'group'         => 'Grup de marcadors',
        'is_draggable'  => 'És arrossegable',
        'latitude'      => 'Latitud',
        'longitude'     => 'Longitud',
        'opacity'       => 'Opacitat',
    ],
    'helpers'       => [
        'base'          => 'Afegiu marcadors al mapa fent clic a qualsevol lloc.',
        'custom_icon'   => 'Copieu l\'HTML d\'una icona de :fontawesome o :rpgawesome, o una icona SVG personalitzada.',
        'draggable'     => 'Permet moure els marcadors al mode d\'exploració.',
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
