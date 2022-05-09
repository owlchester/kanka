<?php

return [
    'actions'       => [
        'delete-confirm'    => 'questo evento atmosferico',
    ],
    'create'        => [
        'success'   => 'Tempo meteorologico aggiunto.',
        'title'     => 'Nuovo evento atmosferico',
    ],
    'destroy'       => [
        'success'   => 'Tempo meteorologico rimosso.',
    ],
    'edit'          => [
        'success'   => 'Tempo meteorologico aggiornato.',
        'title'     => 'Aggiorna il Tempo meteorologico',
    ],
    'fields'        => [
        'effect'        => 'Effetto',
        'name'          => 'Nome',
        'precipitation' => 'Precipitazione',
        'temperature'   => 'Temperatura',
        'weather'       => 'Tempo Meteorologico',
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
        'name'          => 'Testo opzionale per il meteo',
        'precipitation' => 'Quantità di acqua caduta',
        'temperature'   => 'Temperatura massima e minima',
        'wind'          => 'Velocità del vento',
    ],
];
