<?php

return [
    'actions'       => [
        'entry'             => 'Escribir una entrada personalizada para este marcador.',
        'remove'            => 'Eliminar marcador',
        'reset-polygon'     => 'Restablecer posiciones',
        'save_and_explore'  => 'Guardar y explorar',
        'start-drawing'     => 'Empezar a dibujar',
        'update'            => 'Editar marcador',
    ],
    'bulks'         => [
        'delete'    => '{1} Se ha eliminado :count marcador.|[2,*] Se han eliminado :count marcadores.',
        'patch'     => '{1} Se ha actualizado :count marcador.|[2,*] Se han actualizado :count marcadores.',
    ],
    'circle_sizes'  => [
        'custom'    => 'Personalizado',
        'huge'      => 'Enorme',
        'large'     => 'Grande',
        'small'     => 'Pequeño',
        'standard'  => 'Estándar',
        'tiny'      => 'Diminuto',
    ],
    'create'        => [
        'success'   => 'Marcador :name creado.',
        'title'     => 'Nuevo marcador',
    ],
    'delete'        => [
        'success'   => 'Marcador :name eliminado.',
    ],
    'details'       => [
        'from-entity'   => 'De entidad',
    ],
    'edit'          => [
        'success'   => 'Marcador :name actualizado.',
        'title'     => 'Editar marcador :name',
    ],
    'fields'        => [
        'bg_colour'     => 'Color del fondo',
        'circle_radius' => 'Radio circular',
        'copy_elements' => 'Copiar elementos',
        'custom_icon'   => 'Icono personalizado',
        'custom_shape'  => 'Forma personalizada',
        'font_colour'   => 'Color del icono',
        'group'         => 'Grupo de marcadores',
        'icon'          => 'Ícono',
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
        'popupless'     => 'Información emergente',
        'size'          => 'Tamaño',
    ],
    'helpers'       => [
        'base'                      => 'Añade marcadores al mapa haciendo clic en cualquier lugar.',
        'copy_elements'             => 'Copiar grupos, capas y marcadores.',
        'copy_elements_to_campaign' => 'Copiar grupos, capas y marcadores de los mapas. Los marcadores vinculados a una entidad se convertirán en marcadores normales.',
        'css'                       => 'Define una clase CSS personalizada añadida al marcador.',
        'custom_icon_v2'            => 'Utiliza iconos de :fontawesome, :rpgawesome o un icono SVG personalizado. Descubre cómo en la  :docs.',
        'custom_radius'             => 'Selecciona la opción de tamaño personalizado en el desplegable para definir un tamaño.',
        'draggable'                 => 'Actívalo para poder mover el marcador en el modo de exploración.',
        'is_popupless'              => 'Desactiva la aparición del tooltip del marcador al pasar el ratón por encima.',
        'label'                     => 'Las etiquetas se muestran como un bloque de texto en el mapa. El contenido será el nombre del marcador.',
        'polygon'                   => [
            'edit'  => 'Haz clic en el mapa para añadir esa posición a las coordenadas del polígono.',
        ],
    ],
    'hints'         => [
        'entry' => 'Edita el marcador para escribir una entrada personalizada sobre él.',
    ],
    'icons'         => [
        'custom'        => 'Personalizado',
        'entity'        => 'Entidad',
        'exclamation'   => 'Exclamación',
        'marker'        => 'Marcador',
        'question'      => 'Interrogación',
    ],
    'index'         => [
        'title' => 'Marcadores de :name',
    ],
    'pitches'       => [
        'poly'  => 'Dibuje formas poligonales personalizadas para representar fronteras y otras formas irregulares.',
    ],
    'placeholders'  => [
        'custom_icon'   => 'Prueba con :example1 o :example2',
        'custom_shape'  => '100, 100 200, 240 340, 110',
        'name'          => 'Nombre del marcador',
    ],
    'presets'       => [
        'helper'    => 'Haz clic en un preajuste para cargarlo o crea uno nuevo.',
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
        'preset'    => 'Preestablecido',
    ],
];
