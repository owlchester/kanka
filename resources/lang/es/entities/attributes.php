<?php

return [
    'actions'       => [
        'apply_template'    => 'Aplicar plantilla de atributos',
        'manage'            => 'Administrar',
        'more'              => 'Más opciones',
        'remove_all'        => 'Eliminar todos',
    ],
    'errors'        => [
        'loop'  => '¡Hay un bucle infinito en el cálculo de este atributo!',
    ],
    'fields'        => [
        'attribute'             => 'Atributo',
        'community_templates'   => 'Plantillas de la comunidad',
        'is_private'            => 'Atributos privados',
        'is_star'               => 'Fijado',
        'template'              => 'Plantilla',
        'value'                 => 'Valor',
    ],
    'helpers'       => [
        'delete_all'    => '¿Seguro que quieres eliminar todos los atributos de esta entidad?',
    ],
    'hints'         => [
        'is_private'    => 'Oculta todos los atributos de una entidad a todos los miembros no administradores haciéndola privada.',
    ],
    'index'         => [
        'success'   => 'Atributos de :entity actualizados.',
        'title'     => 'Atributos de :name',
    ],
    'placeholders'  => [
        'attribute' => 'Número de conquistas, Iniciativa, Población...',
        'block'     => 'Nombre del bloque',
        'checkbox'  => 'Nombre de la casilla',
        'icon'      => [
            'class' => 'Clase de FontAwesome o RPG Awesome: fas fa-users',
            'name'  => 'Nombre del icono',
        ],
        'random'    => [
            'name'  => 'Nombre del atributo',
            'value' => '1-100 o una lista de valores separados por comas',
        ],
        'section'   => 'Nombre de la sección',
        'template'  => 'Seleccionar plantilla',
        'value'     => 'Valor del atributo',
    ],
    'show'          => [
        'title' => 'Atributos de :name',
    ],
    'template'      => [
        'success'   => 'Plantilla de atributos :name aplicada a :entity',
        'title'     => 'Aplicar plantilla de atributos a :name',
    ],
    'types'         => [
        'attribute' => 'Atributo',
        'block'     => 'Bloque',
        'checkbox'  => 'Casilla',
        'icon'      => 'Icono',
        'random'    => 'Aleatorio',
        'section'   => 'Sección',
        'text'      => 'Texto multilínea',
    ],
    'update'        => [
        'success'   => 'Atributos de :entity actualizados.',
    ],
    'visibility'    => [
        'entry'     => 'El atributo se muestra en el menú de la entidad.',
        'private'   => 'Atributo visible solo para miembros con el rol "Admin".',
        'public'    => 'Atributo visible por todos los miembros.',
        'tab'       => 'El atributo se muestra solo en la pestaña de Atributos.',
    ],
];
