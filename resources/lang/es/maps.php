<?php

return [
    'actions'       => [
        'back'      => 'Volver a :name',
        'edit'      => 'Editar mapa',
        'explore'   => 'Explorar',
    ],
    'create'        => [
        'success'   => 'Mapa :name creado.',
        'title'     => 'Nuevo mapa',
    ],
    'edit'          => [
        'success'   => 'Mapa :name actualizado.',
        'title'     => 'Editar mapa :name',
    ],
    'fields'        => [
        'distance_measure'  => 'Medir distancia',
        'distance_name'     => 'Unidad de distancia',
        'grid'              => 'Cuadrícula',
        'map'               => 'Mapa superior',
        'maps'              => 'Mapas',
        'name'              => 'Nombre',
        'type'              => 'Tipo',
    ],
    'helpers'       => [
        'descendants'       => 'Esta lista contiene todos los mapas descendientes de este, y no solo los que están directamente debajo.',
        'distance_measure'  => 'Al darle al mapa una medida de distancia, se habilitará la herramienta de medidas en el modo de exploración.',
        'grid'              => 'Define un tamaño para la cuadrícula que se mostrará en el modo de exploración.',
        'missing_image'     => 'Guarda el mapa con una imagen antes de añadir capas y marcadores.',
        'nested'            => 'Desde la vista anidada, puedes ver tus mapas de forma anidada. Los mapas que no tengan ningún superior se mostrarán por defecto. Puedes hacer clic sobre los mapas con descendientes para mostrarlos. Puedes seguir haciendo clic hasta que no haya más descendientes que mostrar.',
    ],
    'index'         => [
        'add'   => 'Nuevo mapa',
        'title' => 'Mapas',
    ],
    'maps'          => [
        'title' => 'Mapas de :name',
    ],
    'panels'        => [
        'layers'    => 'Capas',
        'markers'   => 'Marcadores',
        'settings'  => 'Configuración',
    ],
    'placeholders'  => [
        'distance_measure'  => 'Unidades por píxel',
        'distance_name'     => 'Nombre de la unidad de distancia (kilómetro, milla...)',
        'grid'              => 'Distancia en píxeles entre los elementos de la cuadrícula. Déjalo en blanco para esconder la cuadrícula.',
        'name'              => 'Nombre del mapa',
        'type'              => 'Mazmorra, ciudad, galaxia...',
    ],
    'show'          => [
        'tabs'  => [
            'maps'  => 'Mapas',
        ],
        'title' => 'Mapa :name',
    ],
];
