<?php

return [
    'actions'       => [],
    'create'        => [
        'helper'    => 'Adicione informações meteorológicas que serão exibidas no calendário.',
        'success'   => 'Clima adicionado.',
        'title'     => 'Novo clima',
    ],
    'destroy'       => [
        'success'   => 'Clima removido.',
    ],
    'edit'          => [
        'success'   => 'Clima atualizado.',
        'title'     => 'Atualizar clima',
    ],
    'fields'        => [
        'effect'        => 'Efeito',
        'name'          => 'Nome',
        'precipitation' => 'Precipitação',
        'temperature'   => 'Temperatura',
        'weather'       => 'Clima',
        'wind'          => 'Vento',
    ],
    'options'       => [
        'weather'   => [
            'bolt'                  => 'Trovão',
            'cloud'                 => 'Nublado',
            'cloud-rain'            => 'Chuvoso',
            'cloud-showers-heavy'   => 'Chuva forte',
            'cloud-sun'             => 'Nublado e Ensolarado',
            'cloud-sun-rain'        => 'Nuvem, Sol e Chuva',
            'meteor'                => 'Meteoro',
            'smog'                  => 'Nevoeiro',
            'snowflake'             => 'Neve',
            'sun'                   => 'Ensolarado',
            'wind'                  => 'Ventoso',
        ],
    ],
    'placeholders'  => [
        'effect'        => 'Efeito mágico ou natural',
        'name'          => 'Texto opcional e personalizado do clima',
        'precipitation' => 'Quantidade de água',
        'temperature'   => 'Máxima e mínima do dia',
        'wind'          => 'Velocidade do vento',
    ],
];
