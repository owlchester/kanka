<?php

return [
    'create'        => [
        'description'   => 'Crear nueva tirada de dados',
        'success'       => 'Tirada de dados \':name\' creada.',
        'title'         => 'Nueva tirada de dados',
    ],
    'destroy'       => [
        'dice_roll' => 'Tirada de dados eliminada.',
        'success'   => 'Tirada de dados \':name\' eliminada.',
    ],
    'edit'          => [
        'description'   => 'Editar tirada de dados',
        'success'       => 'Tirada de dados \':name\' actualizada.',
        'title'         => 'Editar tirada de dados :name',
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
        'actions'       => [
            'dice'      => 'Tiradas de dados',
            'results'   => 'Resultados',
        ],
        'add'           => 'Nueva tirada de dados',
        'description'   => 'Gestiona las tiradas de dados de :name.',
        'header'        => 'Tirada de dados de :name',
        'title'         => 'Tiradas de dados',
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
        'description'   => 'Vista detallada de tirada de dados',
        'tabs'          => [
            'results'   => 'Resultados',
        ],
        'title'         => 'Tirada de dados :name',
    ],
];
