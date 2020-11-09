<?php

return [
    'create'        => [
        'success'   => 'Clima engadido.',
        'title'     => 'Novo fenómeno climático',
    ],
    'destroy'       => [
        'success'   => 'Clima eliminado.',
    ],
    'edit'          => [
        'success'   => 'Clima actualizado.',
        'title'     => 'Actualizar clima',
    ],
    'fields'        => [
        'effect'        => 'Fenómeno',
        'precipitation' => 'Precipitación',
        'temperature'   => 'Temperatura',
        'weather'       => 'Clima',
        'wind'          => 'Vento',
    ],
    'options'       => [
        'weather'   => [
            'bolt'                  => 'Tormenta',
            'cloud'                 => 'Nublado',
            'cloud-rain'            => 'Chuvia',
            'cloud-showers-heavy'   => 'Chuvascos',
            'cloud-sun'             => 'Nubes e sol',
            'cloud-sun-rain'        => 'Nubes, sol, e chuvia',
            'meteor'                => 'Meteoro',
            'smog'                  => 'Neboeira',
            'snowflake'             => 'Neve',
            'sun'                   => 'Sol',
            'wind'                  => 'Ventoso',
        ],
    ],
    'placeholders'  => [
        'effect'        => 'Fenómeno natural ou máxico',
        'precipitation' => 'Cantidade de auga',
        'temperature'   => 'Máxima e mínima diarias',
        'wind'          => 'Velocidade do vento',
    ],
];
