<?php

return [
    'create'        => [
        'title' => 'Nueva tirada de dados',
    ],
    'destroy'       => [
        'dice_roll' => 'Tirada de dados eliminada.',
    ],
    'edit'          => [],
    'fields'        => [
        'created_at'    => 'Tirada en',
        'parameters'    => 'Parámetros',
        'results'       => 'Resultados',
        'rolls'         => 'Tiradas',
    ],
    'hints'         => [
        'parameters'    => '¿Qué opciones de dados hay?',
    ],
    'index'         => [
        'actions'   => [
            'results'   => 'Resultados',
        ],
    ],
    'lists'         => [
        'empty' => 'Crea y guarda tiradas para la campaña y lleva un registro de los resultados directamente en Kanka.',
    ],
    'placeholders'  => [
        'name'          => 'Nombre de la tirada de dados',
        'parameters'    => '4d6+3',
    ],
    'results'       => [
        'actions'   => [
            'add'   => 'Tirada',
        ],
        'error'     => 'Tirada de dados fallida. No se pueden analizar los parámetros.',
        'fields'    => [
            'creator'   => 'Creador',
            'date'      => 'Fecha',
            'result'    => 'Resultado',
        ],
        'hint'      => 'Todas las tiradas de la plantilla han sido completadas.',
        'success'   => 'Dados tirados.',
    ],
    'show'          => [
        'tabs'  => [
            'results'   => 'Resultados',
        ],
    ],
];
