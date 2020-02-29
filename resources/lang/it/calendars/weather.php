<?php

return [
    'create'        => [
        'success'   => 'Tempo atmosferico aggiunto.',
        'title'     => 'Nuovo Effetto del Tempo Atmosferico',
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
            'bolt'                  => 'Tuono',
            'cloud'                 => 'Nuvoloso',
            'cloud-rain'            => 'Piovoso',
            'cloud-showers-heavy'   => 'Pioggia Pesante',
            'cloud-sun'             => 'Parzialmente Nuvoloso',
            'cloud-sun-rain'        => 'Parzialmente Nuvoloso con Piogge',
            'meteor'                => 'Meteora',
            'smog'                  => 'Smog',
            'snowflake'             => 'Neve',
            'sun'                   => 'Soleggiato',
            'wind'                  => 'Ventoso',
        ],
    ],
    'placeholders'  => [
        'effect'        => 'Effetto magico o naturale',
        'precipitation' => 'Quantitativo di acqua',
        'temperature'   => 'Temperatura massima e minima',
        'wind'          => 'Velocità del vento',
    ],
];
