<?php

return [
    'create'        => [
        'success'   => 'Tempo atmosferico aggiunto.',
        'title'     => 'Nuovo effetto del Tempo Atmosferico',
    ],
    'destroy'       => [
        'success'   => 'Tempo atmosferico rimosso.',
    ],
    'edit'          => [
        'success'   => 'Tempo atmosferico aggiornato.',
        'title'     => 'Aggiorna il Tempo Atmosferico',
    ],
    'fields'        => [
        'effect'        => 'Effetto',
        'precipitation' => 'Precipitazione',
        'temperature'   => 'Temperatura',
        'weather'       => 'Tempo Atmosferico',
        'wind'          => 'Vento',
    ],
    'options'       => [
        'weather'   => [
            'bolt'                  => 'Temporale',
            'cloud'                 => 'Nuvoloso',
            'cloud-rain'            => 'Piovoso',
            'cloud-showers-heavy'   => 'Pioggia Torrenziale',
            'cloud-sun'             => 'Sereno Variabile',
            'cloud-sun-rain'        => 'Parzialmente Nuvoloso con Precipitazioni',
            'meteor'                => 'Meteora',
            'smog'                  => 'Smog',
            'snowflake'             => 'Neve',
            'sun'                   => 'Soleggiato',
            'wind'                  => 'Ventoso',
        ],
    ],
    'placeholders'  => [
        'effect'        => 'Effetto magico o naturale',
        'precipitation' => 'Quantità di acqua caduta',
        'temperature'   => 'Temperatura massima e minima',
        'wind'          => 'Velocità del vento',
    ],
];
