<?php

return [
    'create'        => [
        'success'   => 'Tirada de dados ":name" creada.',
        'title'     => 'Nova tirada de dados',
    ],
    'destroy'       => [
        'dice_roll' => 'Tirada de dados eliminada.',
        'success'   => 'Tirada de dados ":name" eliminada.',
    ],
    'edit'          => [
        'success'   => 'Tirada de dados ":name" actualizada.',
        'title'     => 'Editar tirada de dados ":name"',
    ],
    'fields'        => [
        'created_at'    => 'Tirada en',
        'name'          => 'Nome',
        'parameters'    => 'Parámetros',
        'results'       => 'Resultados',
        'rolls'         => 'Tiradas',
    ],
    'hints'         => [
        'parameters'    => 'Que opcións de dados hai?',
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
        'name'      => 'Nome da tirada de dados',
        'parameters'=> '4d6+3',
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
