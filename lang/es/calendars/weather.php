<?php

return [
    'actions'       => [],
    'create'        => [
        'helper'    => 'Agrega información meteorológica que aparecerá en el calendario.',
        'success'   => 'Clima añadido.',
        'title'     => 'Nuevo fenómeno climático',
    ],
    'destroy'       => [
        'success'   => 'Clima eliminado.',
    ],
    'edit'          => [
        'success'   => 'Clima actualizado.',
        'title'     => 'Actualizar clima',
    ],
    'fields'        => [
        'effect'        => 'Efecto',
        'name'          => 'Nombre',
        'precipitation' => 'Precipitación',
        'temperature'   => 'Temperatura',
        'weather'       => 'Clima',
        'wind'          => 'Viento',
    ],
    'options'       => [
        'weather'   => [
            'bolt'                  => 'Tormentas',
            'cloud'                 => 'Nublado',
            'cloud-rain'            => 'Lluvioso',
            'cloud-showers-heavy'   => 'Chubascos',
            'cloud-sun'             => 'Nublado y soleado',
            'cloud-sun-rain'        => 'Nubes, sol y lluvia',
            'meteor'                => 'Meteorito',
            'smog'                  => 'Neblina',
            'snowflake'             => 'Nieve',
            'sun'                   => 'Soleado',
            'wind'                  => 'Ventoso',
        ],
    ],
    'placeholders'  => [
        'effect'        => 'Fenómeno natural o mágico',
        'name'          => 'Texto opcional personalizado del clima',
        'precipitation' => 'Cantidad de agua',
        'temperature'   => 'Máxima y mínima diaria',
        'wind'          => 'Velocidad del viento',
    ],
];
