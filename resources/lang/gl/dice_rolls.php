<?php

return [
    'create'        => [
        'description'   => 'Crear nova tirada de dados',
        'success'       => 'Tirada de dados ":name" creada.',
        'title'         => 'Nova tirada de dados',
    ],
    'destroy'       => [
        'dice_roll' => 'Tirada de dados eliminada.',
        'success'   => 'Tirada de dados ":name" eliminada.',
    ],
    'edit'          => [
        'description'   => 'Editar unha tirada de dados',
        'success'       => 'Tirada de dados ":name" actualizada.',
        'title'         => 'Editar tirada de dados ":name"',
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
        'actions'       => [
            'dice'      => 'Tiradas de dados',
            'results'   => 'Resultados',
        ],
        'add'           => 'Nova tirada de dados',
        'description'   => 'Xestiona as tiradas de dados de ":name"',
        'header'        => 'Tiradas de dados de :name',
        'title'         => 'Tiradas de dados',
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
        'description'   => 'Vista detallada dunha tirada de dados',
        'tabs'          => [
            'results'   => 'Resultados',
        ],
        'title'         => 'Tirada de dados ":name"',
    ],
];
