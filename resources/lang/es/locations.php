<?php

return [
    'create'        => [
        'description'   => 'Crear nueva localización',
        'success'       => 'Lugar \':name\' creado.',
        'title'         => 'Nueva localización',
    ],
    'destroy'       => [
        'success'   => 'Localización \':name\' borrada.',
    ],
    'edit'          => [
        'success'   => 'Lugar \':name\' actualizado.',
        'title'     => 'Editar localización :name',
    ],
    'fields'        => [
        'characters'    => 'Personajes',
        'image'         => 'Imagen',
        'location'      => 'Localización',
        'locations'     => 'Lugares',
        'map'           => 'Mapa',
        'name'          => 'Nombre',
        'relation'      => 'Vínculo',
        'type'          => 'Tipo',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Vista de exploración',
        ],
        'add'           => 'Nueva Localización',
        'description'   => 'Gestionar la localización de :name.',
        'header'        => 'Lugares en :name',
        'title'         => 'Lugares',
    ],
    'map'           => [
        'actions'   => [
            'big'           => 'Vista completa',
            'download'      => 'Descargar',
            'points'        => 'Editar puntos',
            'toggle_hide'   => 'Ocultar puntos',
            'toggle_show'   => 'Mostrar puntos',
            'zoom_in'       => 'Acercar',
            'zoom_out'      => 'Alejar',
        ],
        'helper'    => 'Haz click en el mapa para añadir un nuevo punto a una localización, o selecciona un punto existente para editarlo o eliminarlo.',
        'modal'     => [
            'submit'    => 'Añadir',
            'title'     => 'Selección de nuevo punto',
        ],
        'no_map'    => 'Por favor, sube el mapa de la localización primero.',
        'points'    => [
            'fields'        => [
                'axis_x'    => 'Eje X',
                'axis_y'    => 'Eje Y',
                'colour'    => 'Color',
            ],
            'placeholders'  => [
                'axis_x'    => 'Posición izquierda',
                'axis_y'    => 'Posición superior',
            ],
            'return'        => 'Volver a :name',
            'success'       => [
                'create'    => 'Punto de localización creado en el mapa.',
                'delete'    => 'Punto de localización eliminado del mapa.',
                'update'    => 'Punto de localización actualizado en el mapa.',
            ],
            'title'         => 'Puntos del mapa de la localización :name',
        ],
        'success'   => 'Puntos del mapa guardados.',
    ],
    'placeholders'  => [
        'location'  => 'Elige un lugar vinculado',
        'name'      => 'Nombre del lugar',
        'type'      => 'Ciudad, Reino, Ruinas',
    ],
    'show'          => [
        'description'   => 'Vista detallada del lugar',
        'tabs'          => [
            'characters'    => 'Personajes',
            'information'   => 'Información',
            'locations'     => 'Lugares',
            'map'           => 'Mapa',
        ],
        'title'         => 'Lugar :name',
    ],
];
