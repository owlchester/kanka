<?php

return [
    'actions'       => [
        'back'      => 'Voltar a :name',
        'edit'      => 'Editar mapa',
        'explore'   => 'Explorar',
    ],
    'create'        => [
        'title' => 'Novo mapa',
    ],
    'destroy'       => [],
    'edit'          => [],
    'errors'        => [
        'chunking'  => [
            'error'     => 'Houbo un erro ao fragmentar o mapa. Contacta co equipo de soporte no :discord.',
            'running'   => [
                'edit'      => 'O mapa non pode ser editado mentres está fragmentado.',
                'explore'   => 'O mapa non pode ser mostrado mentres está fragmentado.',
                'time'      => 'Isto pode levar dende uns minutos ata varias horas, dependendo do tamaño do mapa.',
            ],
        ],
        'dashboard' => [
            'missing'   => 'Este mapa precisa unha imaxe para poder ser mostrado no taboleiro.',
        ],
        'explore'   => [
            'missing'   => 'Por favor, engade unha imaxe ao mapa para poder exploralo.',
        ],
    ],
    'fields'        => [
        'center_marker' => 'Marcador',
        'center_x'      => 'Posición de lonxitude por defecto',
        'center_y'      => 'Posición de latitude por defecto',
        'centering'     => 'Centrado',
        'grid'          => 'Reixa',
        'has_clustering'=> 'Agrupar marcadores',
        'initial_zoom'  => 'Zoom inicial',
        'is_real'       => 'Usar OpenStreetMaps',
        'map'           => 'Mapa superior',
        'maps'          => 'Mapas',
        'max_zoom'      => 'Zoom máximo',
        'min_zoom'      => 'Zoom mínimo',
        'name'          => 'Nome',
        'tabs'          => [
            'coordinates'   => 'Coordenadas',
            'marker'        => 'Marcador',
        ],
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'center'            => 'Os seguintes valores controlan en que área do mapa está o foco. Deixar estes valores baleiros fará que o foco esté no centro.',
        'centering'         => 'Centrar nun marcador será prioritario sobre as coordenadas por defecto.',
        'chunked_zoom'      => 'Agrupar marcadores automaticamente cando están preto uns dos outros.',
        'descendants'       => 'Esta lista contén todos os mapas descendentes deste mapa, non só os directamente debaixo del.',
        'distance_measure'  => 'Engadir unha medida da distancia ao mapa, habilitará a ferramenta de medida no modo de exploración.',
        'grid'              => 'Establece un tamaño para a reixa que se mostrará no modo de exploración.',
        'has_clustering'    => 'Agrupar marcadores automaticamente cando están preto uns dos outros.',
        'initial_zoom'      => 'O nivel inicial de zoom co que se cargará o mapa. O valor por defecto é :default, mentres que os valores máximo e mínimo permitidos son :max e :min, respectivamente.',
        'is_real'           => 'Selecciona esta opción se queres usar un mapa do mundo real en vez de subir unha imaxe. Esta opción deshabilita as capas.',
        'max_zoom'          => 'O máximo que pode ser ampliado o mapa. O valor por defecto é :default, e o máximo permitido é :max.',
        'min_zoom'          => 'O valor mínimo de zoom permitido. O valor por defecto é :default, mentres que o valor mínimo permito é :min.',
        'missing_image'     => 'Garda o mapa cunha imaxe antes de engadir capas e marcadores.',
        'nested_without'    => 'Mostrando todos os mapas que non teñen un mapa superior. Fai clic nunha fila para ver os seus descendentes.',
    ],
    'index'         => [
        'title' => 'Mapas',
    ],
    'maps'          => [
        'title' => 'Mapas de ":name"',
    ],
    'panels'        => [
        'groups'    => 'Grupos',
        'layers'    => 'Capas',
        'markers'   => 'Marcadores',
        'settings'  => 'Configuración',
    ],
    'placeholders'  => [
        'center_marker' => 'Déixao baleiro para cargar o mapa no centro',
        'center_x'      => 'Déixao baleiro para cargar o mapa no centro',
        'center_y'      => 'Déixao baleiro para cargar o mapa no centro',
        'grid'          => 'Distancia en píxeis entre elementos da reixa. Deixar baleiro para ocultar a reixa.',
        'name'          => 'Nome do mapa',
        'type'          => 'Cripta, cidade, galaxia...',
    ],
    'show'          => [
        'tabs'  => [
            'maps'  => 'Mapas',
        ],
    ],
    'tooltips'      => [
        'chunking'  => [
            'running'   => 'O mapa está sendo fragmentado. Este proceso pode levar dende minutos ata horas.',
        ],
    ],
];
