<?php

return [
    'fields'    => [
        'character_personality_visibility'  => 'Visibilidad predeterminada de la personalidad del personaje',
        'connections'                       => 'Vista de conexiones de la entidad',
        'connections_mode'                  => 'Estilo del mapa de conexiones',
        'descendants'                       => 'Filtrado predeterminado de sublistas',
        'entity_privacy'                    => 'Visibilidad de nuevas entidades',
        'gallery_visibility'                => 'Visibilidad predeterminada de imágenes de la galería',
        'post_collapsed'                    => 'Diseño de nuevas publicaciones',
        'private_mention_visibility'        => 'Menciones privadas de entidades',
        'related_visibility'                => 'Visibilidad de contenido relacionado',
    ],
    'helpers'   => [
        'character_visibility'          => 'Establece la visibilidad de los rasgos de personalidad al crear personajes.',
        'connections'                   => 'Elige si las páginas de conexiones de entidades muestran un mapa visual o una lista de forma predeterminada.',
        'connections_mode'              => 'Establece el estilo de diseño predeterminado para los mapas de conexiones (disponible con premium).',
        'descendants'                   => 'Al ver sublistas de entidades (como los personajes de una ubicación), muestra solo los descendientes directos o todos los descendientes.',
        'display'                       => 'Establece las opciones de visualización predeterminadas para las páginas de entidades.',
        'entity'                        => 'Controla qué visibilidad aplica Kanka automáticamente al nuevo contenido.',
        'entity_privacy'                => 'Establece la visibilidad de personajes, ubicaciones y otros elementos recién creados.',
        'gallery_visibility'            => 'Valor de visibilidad predeterminado al subir imágenes a la galería.',
        'post_collapsed'                => 'Al crear publicaciones en entidades, establece si la publicación aparece colapsada o expandida.',
        'privacy'                       => 'Establece las visibilidades predeterminadas para el nuevo contenido. Estos ajustes se aplican al crear contenido nuevo y pueden modificarse en elementos individuales.',
        'private_mention_visibility'    => 'Cuando mencionas una entidad privada en contenido visible, controla si el nombre de la entidad se muestra u oculta.',
        'related_visibility'            => 'Controla la visibilidad de publicaciones, atributos y conexiones añadidos a las entidades.',
    ],
    'sections'  => [
        'display'   => 'Valores predeterminados de visualización de entidades',
        'entity'    => 'Valores predeterminados de entidades',
        'media'     => 'Valores predeterminados de medios',
        'mention'   => 'Comportamiento de menciones',
    ],
    'tutorial'  => 'Agiliza la creación de contenido con valores predeterminados inteligentes. Elige configuraciones de visibilidad predeterminadas para entidades, publicaciones, imágenes y otros contenidos. Estas preferencias se aplicarán automáticamente al crear nuevo contenido, ahorrándote tiempo y manteniendo tu campaña organizada.',
    'update'    => [
        'success'   => 'Valores predeterminados de la campaña actualizados.',
    ],
    'values'    => [
        'collapsed'     => [
            'collapsed' => 'Colapsado',
            'default'   => 'Predeterminado',
            'expanded'  => 'Expandido',
        ],
        'connections'   => [
            'explorer'  => 'Mapa de conexiones (premium)',
            'list'      => 'Interfaz de lista',
        ],
        'descendants'   => [
            'all'       => 'Mostrar todos los descendientes de forma predeterminada',
            'direct'    => 'Mostrar descendientes directos de forma predeterminada',
        ],
        'mentions'      => [
            'private'   => 'Ocultar nombre del objetivo',
            'visible'   => 'Mostrar nombre del objetivo',
        ],
    ],
];
