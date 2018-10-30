<?php

return [
    'characters'    => [
        'description'   => 'Personajes que están en este lugar.',
        'title'         => 'Personajes en :name',
    ],
    'create'        => [
        'description'   => 'Crear nuevo lugar',
        'success'       => 'Lugar \':name\' creado.',
        'title'         => 'Nuevo lugar',
    ],
    'destroy'       => [
        'success'   => 'Lugar \':name\' borrado.',
    ],
    'edit'          => [
        'success'   => 'Lugar \':name\' actualizado.',
        'title'     => 'Editar lugar :name',
    ],
    'events'        => [
        'description'   => 'Eventos que ocurren en este lugar.',
        'title'         => 'Eventos en :name',
    ],
    'fields'        => [
        'characters'    => 'Personajes',
        'image'         => 'Imagen',
        'location'      => 'Lugar',
        'locations'     => 'Lugares',
        'map'           => 'Mapa',
        'name'          => 'Nombre',
        'relation'      => 'Vínculo',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'descendants'   => 'Esta lista contiene todas las localizaciones que son descendientes de estos lugares, además de las que están directamente por debajo.',
        'nested'        => 'En la Vista de Exploración puedes ver tus lugares de forma anidada. Las localizaciones que no tengan ninguna superior se mostrarán aquí por defecto. Las que tengan localizaciones anidadas se pueden ir clicando para mostrarlas. Puedes seguir haciendo click hasta que no haya más lugares anidados que ver.',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Vista de exploración',
        ],
        'add'           => 'Nuevo Lugar',
        'description'   => 'Gestiona los lugares de :name.',
        'header'        => 'Lugares en :name',
        'title'         => 'Lugares',
    ],
    'items'         => [
        'description'   => 'Objetos situados o procedentes de este lugar.',
        'title'         => 'Objetos de :name',
    ],
    'locations'     => [
        'description'   => 'Lugares situados en esta localización.',
        'title'         => 'Lugares de :name',
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
                'name'      => 'Etiqueta',
            ],
            'helpers'       => [
                'location_or_name'  => 'Un punto del mapa puede dirigir a una localización existente, o simplemente tener una etiqueta.',
            ],
            'placeholders'  => [
                'axis_x'    => 'Posición izquierda',
                'axis_y'    => 'Posición superior',
                'name'      => 'Etiqueta del punto cuando no se ha establecido ninguna localización.',
            ],
            'return'        => 'Volver a :name',
            'success'       => [
                'create'    => 'Punto de localización creado en el mapa.',
                'delete'    => 'Punto de localización eliminado del mapa.',
                'update'    => 'Punto de localización actualizado en el mapa.',
            ],
            'title'         => 'Puntos del mapa de :name',
        ],
        'success'   => 'Puntos del mapa guardados.',
    ],
    'organisations' => [
        'description'   => 'Organizaciones situadas en la localización.',
        'title'         => 'Organizaciones de :name',
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
            'events'        => 'Eventos',
            'information'   => 'Información',
            'items'         => 'Objetos',
            'locations'     => 'Lugares',
            'map'           => 'Mapa',
            'menu'          => 'Menú',
            'organisations' => 'Organizaciones',
        ],
        'title'         => 'Lugar :name',
    ],
];
