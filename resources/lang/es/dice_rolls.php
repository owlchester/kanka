<?php

return [
    'create'        => [
        'success'   => 'Tirada de dados \':name\' creada.',
        'title'     => 'Nueva tirada de dados',
    ],
    'destroy'       => [
        'dice_roll' => 'Tirada de dados eliminada.',
        'success'   => 'Tirada de dados \':name\' eliminada.',
    ],
    'edit'          => [
        'success'   => 'Tirada de dados \':name\' actualizada.',
        'title'     => 'Editar tirada de dados :name',
    ],
    'fields'        => [
        'created_at'    => 'Tirada en',
        'name'          => 'Nombre',
        'parameters'    => 'Parámetros',
        'results'       => 'Resultados',
        'rolls'         => 'Tiradas',
    ],
    'hints'         => [
        'parameters'    => '¿Qué opciones de dados hay?',
    ],
    'index'         => [
        'actions'   => [
            'dice'      => 'Tiradas de dados',
            'results'   => 'Resultados',
        ],
        'title'     => 'Tiradas de dados',
    ],
    'placeholders'  => [
        'dice_roll' => 'Tirada de dados',
        'name'      => 'Nombre de la tirada de dados',
        'parameters'=> '4d6+3',
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
