<?php

return [
    'actions'       => [
        'entry'             => 'Escreber unha entrada personalizada para este marcador.',
        'remove'            => 'Eliminar marcador',
        'save_and_explore'  => 'Gardar e Explorar',
        'update'            => 'Editar marcador',
    ],
    'create'        => [
        'success'   => 'Marcador ":name" creado.',
        'title'     => 'Novo marcador',
    ],
    'delete'        => [
        'success'   => 'Marcador ":name" eliminado.',
    ],
    'edit'          => [
        'success'   => 'Marcador ":name" actualizado.',
        'title'     => 'Editar marcador ":name"',
    ],
    'fields'        => [
        'circle_radius' => 'Radio circular',
        'copy_elements' => 'Copiar elementos',
        'custom_icon'   => 'Icona personalizada',
        'custom_shape'  => 'Forma personalizada',
        'font_colour'   => 'Cor da icona',
        'group'         => 'Grupo de marcadores',
        'is_draggable'  => 'Arrastrábel',
        'latitude'      => 'Latitude',
        'longitude'     => 'Lonxitude',
        'opacity'       => 'Opacidade',
        'pin_size'      => 'Tamaño do marcador',
        'polygon_style' => [
            'stroke'            => 'Color do trazo',
            'stroke-opacity'    => 'Opacidade do trazo',
            'stroke-width'      => 'Anchura do trazo',
        ],
    ],
    'helpers'       => [
        'base'                      => 'Engade marcadores ao mapa facendo clic en calquer punto.',
        'copy_elements'             => 'Copiar grupos, capas, e marcadores.',
        'copy_elements_to_campaign' => 'Copiar grupos, capas, e marcadores dos mapas. Os marcadores ligados a unha entidade serán convertidos a marcadores estándar.',
        'custom_icon'               => 'Copia o HTML dunha icona de :fontawesome ou de :rpgawesome, ou unha icona SVG personalizada.',
        'custom_radius'             => 'Seleccionar a opción de tamaño personalizado no menú despregábel para definir un tamaño.',
        'draggable'                 => 'Actívao para poder mover un marcador no modo de exploración.',
        'label'                     => 'Un rótulo é mostrado como un bloque de texto no mapa. O contido será o nome do marcador.',
        'polygon'                   => [
            'edit'  => 'Fai clic no mapa para engadir esa posición ás coordenadas do polígono.',
            'new'   => 'Move o marcador polo mapa para gardar a posición ao polígono.',
        ],
    ],
    'icons'         => [
        'custom'        => 'Personalizado',
        'entity'        => 'Entidade',
        'exclamation'   => 'Exclamación',
        'marker'        => 'Marcador',
        'question'      => 'Interrogación',
    ],
    'placeholders'  => [
        'custom_shape'  => '100,100 200,240 340,110',
        'name'          => 'Necesario se non hai ningunha entidade seleccionada',
    ],
    'shapes'        => [
        '0' => 'Círculo',
        '1' => 'Cadrado',
        '2' => 'Triángulo',
        '3' => 'Personalizada',
    ],
    'sizes'         => [
        '0' => 'Minúsculo',
        '1' => 'Estándar',
        '2' => 'Pequeno',
        '3' => 'Grande',
        '4' => 'Enorme',
    ],
    'tabs'          => [
        'circle'    => 'Círculo',
        'label'     => 'Rótulo',
        'marker'    => 'Marcador',
        'polygon'   => 'Polígono',
    ],
];
