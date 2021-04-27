<?php

return [
    'actions'       => [
        'entry'             => 'Escribir una entrada personalizada para este marcador.',
        'remove'            => 'Eliminar marcador',
        'save_and_explore'  => 'Guardar y explorar',
        'update'            => 'Editar marcador',
    ],
    'create'        => [
        'success'   => 'Marcador :name creado.',
        'title'     => 'Nuevo marcador',
    ],
    'delete'        => [
        'success'   => 'Marcador :name eliminado.',
    ],
    'edit'          => [
        'success'   => 'Marcador :name actualizado.',
        'title'     => 'Editar marcador :name',
    ],
    'fields'        => [
        'circle_radius' => 'Radio circular',
        'copy_elements' => 'Copiar elementos',
        'custom_icon'   => 'Icono personalizado',
        'custom_shape'  => 'Forma personalizada',
        'font_colour'   => 'Color del icono',
        'group'         => 'Grupo de marcadores',
        'is_draggable'  => 'Arrastrable',
        'latitude'      => 'Latitud',
        'longitude'     => 'Longitud',
        'opacity'       => 'Opacidad',
        'pin_size'      => 'Tamaño del marcador',
        'polygon_style' => [
            'stroke'            => 'Color del trazo',
            'stroke-opacity'    => 'Opacidad del trazo',
            'stroke-width'      => 'Grosor del trazo',
        ],
    ],
    'helpers'       => [
        'base'                      => 'Añade marcadores al mapa haciendo clic en cualquier lugar.',
        'copy_elements'             => 'Copiar grupos, capas y marcadores.',
        'copy_elements_to_campaign' => 'Copiar grupos, capas y marcadores de los mapas. Los marcadores vinculados a una entidad se convertirán en marcadores normales.',
        'custom_icon'               => 'Copia el HTML de un icono de :fontawesome o :rpgawesome, o un icono SVG personalizado.',
        'custom_radius'             => 'Selecciona la opción de tamaño personalizado en el desplegable para definir un tamaño.',
        'draggable'                 => 'Actívalo para poder mover el marcador en el modo de exploración.',
        'label'                     => 'Las etiquetas se muestran como un bloque de texto en el mapa. El contenido será el nombre del marcador.',
        'polygon'                   => [
            'edit'  => 'Haz clic en el mapa para añadir esa posición a las coordenadas del polígono.',
            'new'   => 'Mueve el marcador por el mapa para guardar la posición del polígono.',
        ],
    ],
    'icons'         => [
        'custom'        => 'Personalizado',
        'entity'        => 'Entidad',
        'exclamation'   => 'Exclamación',
        'marker'        => 'Marcador',
        'question'      => 'Interrogación',
    ],
    'placeholders'  => [
        'custom_shape'  => '100, 100 200, 240 340, 110',
        'name'          => 'Nombre del marcador',
    ],
    'shapes'        => [
        '0' => 'Círculo',
        '1' => 'Cuadrado',
        '2' => 'Triángulo',
        '3' => 'Personalizada',
    ],
    'sizes'         => [
        '0' => 'Minúsculo',
        '1' => 'Estándar',
        '2' => 'Pequeño',
        '3' => 'Grande',
        '4' => 'Enorme',
    ],
    'tabs'          => [
        'circle'    => 'Círculo',
        'label'     => 'Etiqueta',
        'marker'    => 'Marcador',
        'polygon'   => 'Polígono',
    ],
];
