<?php

return [
    'create'        => [
        'success'   => 'S\'ha afegit el clima.',
        'title'     => 'Nou fenomen climàtic',
    ],
    'destroy'       => [
        'success'   => 'S\'ha eliminat el clima.',
    ],
    'edit'          => [
        'success'   => 'S\'ha actualitzat el clima.',
        'title'     => 'Actualiza el clima',
    ],
    'fields'        => [
        'effect'        => 'Efecte',
        'precipitation' => 'Precipitació',
        'temperature'   => 'Temperatura',
        'weather'       => 'Clima',
        'wind'          => 'Vent',
    ],
    'options'       => [
        'weather'   => [
            'bolt'                  => 'Tempestes',
            'cloud'                 => 'Núvols',
            'cloud-rain'            => 'Pluges',
            'cloud-showers-heavy'   => 'Xàfecs',
            'cloud-sun'             => 'Núvols i sol',
            'cloud-sun-rain'        => 'Núvols, sol i pluja',
            'meteor'                => 'Meteorit',
            'smog'                  => 'Boira',
            'snowflake'             => 'Neu',
            'sun'                   => 'Sol',
            'wind'                  => 'Ventades',
        ],
    ],
    'placeholders'  => [
        'effect'        => 'Fenomen natural o màgic',
        'precipitation' => 'Quantitat d\'aigua',
        'temperature'   => 'Màxima i mínima diària',
        'wind'          => 'Velocitat del vent',
    ],
];
