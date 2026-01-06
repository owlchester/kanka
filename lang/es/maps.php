<?php

return [
    'actions'       => [
        'back'      => 'Volver a :name',
        'edit'      => 'Editar mapa',
        'explore'   => 'Explorar',
    ],
    'create'        => [
        'title' => 'Nuevo mapa',
    ],
    'destroy'       => [],
    'edit'          => [],
    'errors'        => [
        'chunking'  => [
            'error'     => 'Se ha producido un error al fragmentar el mapa. Ponte en contacto con el equipo en :discord para obtener ayuda.',
            'running'   => [
                'edit'      => 'El mapa no se puede editar mientras se esté fragmentando.',
                'explore'   => 'El mapa no puede visualizarse mientras se está fragmentando.',
                'time'      => 'Esto puede llevar de varios minutos a varias horas, dependiendo del tamaño del mapa.',
            ],
        ],
        'dashboard' => [
            'missing'   => 'Este mapa necesita una imagen para que se pueda mostrar en el tablero.',
        ],
        'explore'   => [
            'missing'   => 'Por favor, añade una imagen al mapa para poder explorarlo.',
        ],
    ],
    'fields'        => [
        'center_marker'     => 'Marcador',
        'center_x'          => 'Posicionamiento (longitud) por defecto',
        'center_y'          => 'Posicionamiento (latitud) por defecto',
        'centering'         => 'Centrar',
        'distance_measure'  => 'Medida de la distancia',
        'distance_name'     => 'Etiqueta de unidad de distancia',
        'grid'              => 'Cuadrícula',
        'has_clustering'    => 'Marcadores de agrupamiento',
        'initial_zoom'      => 'Zoom inicial',
        'is_real'           => 'Usar OpenStreetMaps',
        'max_zoom'          => 'Zoom máximo',
        'min_zoom'          => 'Zoom mínimo',
        'tabs'              => [
            'coordinates'   => 'Coordenadas',
            'marker'        => 'Marcador',
        ],
    ],
    'helpers'       => [
        'center'                => 'Cambia estos valores para controlar en qué área está focalizado el mapa. Si lo dejas en blanco, se mostrará el centro del mapa por defecto.',
        'centering'             => 'Si un marcador está centrado, tendrá prioridad sobre las coordenadas por defecto.',
        'chunked_zoom'          => 'Agrupa automáticamente los marcadores cuando están próximos entre sí.',
        'distance_measure'      => 'Al darle al mapa una medida de distancia, se habilitará la herramienta de medidas en el modo de exploración.',
        'distance_measure_2'    => 'Para que 100 píxeles midan 1 kilómetro, introduce un valor de 0.0041.',
        'grid'                  => 'Define un tamaño para la cuadrícula que se mostrará en el modo de exploración.',
        'has_clustering'        => 'Agrupa automáticamente los marcadores cuando están próximos entre sí.',
        'initial_zoom'          => 'El nivel inicial de zoom en el que se carga el mapa. El valor por defecto es :default, mientras que el valor máximo permitido es :max, y el mínimo, :min.',
        'is_real'               => 'Selecciona esta opción si quieres usar un mapa del mundo real en lugar de la imagen. Esta opción deshabilita las capas.',
        'max_zoom'              => 'El máximo que se puede acercar un mapa. El valor por defecto es :default, mientras que el valor máximo permitido es :max.',
        'min_zoom'              => 'El máximo que se puede alejar un mapa. El valor por defecto es :default, mientras que el valor máximo permitido es :min.',
        'missing_image'         => 'Guarda el mapa con una imagen antes de añadir capas y marcadores.',
    ],
    'index'         => [],
    'lists'         => [
        'empty' => 'Sube un mapa para visualizar las ubicaciones y mostrar la geografía de tu mundo.',
    ],
    'maps'          => [],
    'panels'        => [
        'groups'    => 'Grupos',
        'layers'    => 'Capas',
        'legend'    => 'Leyenda',
        'markers'   => 'Marcadores',
        'settings'  => 'Configuración',
    ],
    'placeholders'  => [
        'center_marker' => 'Dejar en blanco para cargar el mapa en el centro',
        'center_x'      => 'Dejar en blanco para cargar el mapa en el centro',
        'center_y'      => 'Dejar en blanco para cargar el mapa en el centro',
        'distance_name' => 'Km, millas, pies, hamburguesas',
        'grid'          => 'Distancia en píxeles entre los elementos de la cuadrícula. Déjalo en blanco para esconder la cuadrícula.',
        'name'          => 'Nombre del mapa',
        'type'          => 'Mazmorra, ciudad, galaxia...',
    ],
    'show'          => [
        'tabs'  => [
            'maps'  => 'Mapas',
        ],
    ],
    'tooltips'      => [
        'chunking'  => [
            'running'   => 'El mapa se está fragmentando. Este proceso puede durar de varios minutos a horas.',
        ],
    ],
];
