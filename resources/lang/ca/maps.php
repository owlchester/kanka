<?php

return [
    'actions'       => [
        'back'      => 'Torna a :name',
        'edit'      => 'Edita el mapa',
        'explore'   => 'Explora',
    ],
    'create'        => [
        'success'   => 'S\'ha creat el mapa «:name».',
        'title'     => 'Nou mapa',
    ],
    'destroy'       => [
        'success'   => 'S\'ha eliminat el mapa «:name».',
    ],
    'edit'          => [
        'success'   => 'S\'ha actualitzat el mapa «:name».',
        'title'     => 'Edita el mapa :name',
    ],
    'errors'        => [
        'dashboard' => [
            'missing'   => 'Aquest mapa necessita una imatge perquè es pugui mostrar al tauler.',
        ],
        'explore'   => [
            'missing'   => 'Afegiu una imatge al mapa per a poder explorar-lo.',
        ],
    ],
    'fields'        => [
        'center_marker'     => 'Marcador',
        'center_x'          => 'Posició X per defecte (longitud)',
        'center_y'          => 'Posició Y per defecte (latitud)',
        'centering'         => 'Centrar',
        'distance_measure'  => 'Medeix distàncies',
        'distance_name'     => 'Unitat de distància',
        'grid'              => 'Cuadrícula',
        'initial_zoom'      => 'Zoom inicial',
        'is_real'           => 'Utilitza OpenStreetMaps',
        'map'               => 'Mapa superior',
        'maps'              => 'Mapes',
        'max_zoom'          => 'Zoom màxim',
        'min_zoom'          => 'Zoom mínim',
        'name'              => 'Nom',
        'tabs'              => [
            'coordinates'   => 'Coordenades',
            'marker'        => 'Marcador',
        ],
        'type'              => 'Tipus',
    ],
    'helpers'       => [
        'center'            => 'Mitjançant aquests valors, es pot controlar quina àrea del mapa es focalitza en carregar-lo. Si es deixen en blanc, el mapa es carregarà focalitzat al centre.',
        'centering'         => 'El centrat d\'un marcador tindrà prioritat sobre les coordenades per defecte.',
        'descendants'       => 'Aquí es mostren tots els mapes descendents d\'aquest, i no només els directament inferiors.',
        'distance_measure'  => 'En donar-li al mapa una mesura de distància, s\'habilitarà l\'eina de mesures al mode d\'exploració.',
        'grid'              => 'Definiu una grandària per a la quadrícula que es mostrarà al mode d\'exploració.',
        'initial_zoom'      => 'El nivell inicial de zoom amb el qual es carrega el mapa. El valor per defecte és :default, mentre que el valor màxim permès és :max, i el mínim, :min.',
        'is_real'           => 'Seleccioneu aquesta opció si voleu fer servir un mapa del món real enlloc de la imatge pujada. Aquesta opció deshabilitarà les capes.',
        'max_zoom'          => 'El màxim que es pot acostar un mapa. El valor per defecte és :default, mentre que el valor màxim permès és :max.',
        'min_zoom'          => 'El màxim que es pot allunyar un mapa. El valor per defecte és :default, mentre que el valor màxim permès és :min.',
        'missing_image'     => 'Cal guardar el mapa amb una imatge abans d\'afegir-hi capes i marcadors.',
        'nested_parent'     => 'S\'estan mostrant els mapes de :parent.',
        'nested_without'    => 'S\'estan mostrant els mapes sense pare. Feu clic a la fila d\'un mapa per a mostrar-ne els descendents.',
    ],
    'index'         => [
        'title' => 'Mapes',
    ],
    'maps'          => [
        'title' => 'Mapes de :name',
    ],
    'panels'        => [
        'groups'    => 'Grups',
        'layers'    => 'Capes',
        'markers'   => 'Marcadors',
        'settings'  => 'Configuració',
    ],
    'placeholders'  => [
        'center_marker'     => 'Deixeu-ho en blanc per a carregar el mapa al centre',
        'center_x'          => 'Deixeu-ho en blanc per a carregar el mapa al centre',
        'center_y'          => 'Deixeu-ho en blanc per a carregar el mapa al centre',
        'distance_measure'  => 'Unitats per píxel',
        'distance_name'     => 'Nom de la unitat de distància (kilòmetre, milla...)',
        'grid'              => 'Distància en píxels entre els elements de la quadrícula. Deixeu-ho en blanc per a amagar la quadrícula.',
        'name'              => 'Nom del mapa',
        'type'              => 'Masmorra, ciutat, galàxia...',
    ],
    'show'          => [
        'tabs'  => [
            'maps'  => 'Mapes',
        ],
    ],
];
