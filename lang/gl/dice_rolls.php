<?php

return [
    'create'        => [
        'title' => 'Nova tirada de dados',
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
        'parameters'    => 'Que opcións de dados hai?',
    ],
    'index'         => [
        'actions'   => [
            'results'   => 'Resultados',
        ],
    ],
    'placeholders'  => [
        'name'          => 'Nome da tirada de dados',
        'parameters'    => '4d6+3',
    ],
    'results'       => [
        'actions'   => [
            'add'   => 'Tirada',
        ],
        'error'     => 'Tirada de dados falida. Os parámetros non poideron ser lidos.',
        'fields'    => [
            'creator'   => 'Creadora',
            'date'      => 'Data',
            'result'    => 'Resultado',
        ],
        'hint'      => 'Todas as tiradas feitas con este padrón de tirada de dados.',
        'success'   => 'Dados tirados.',
    ],
    'show'          => [
        'tabs'  => [
            'results'   => 'Resultados',
        ],
    ],
];
