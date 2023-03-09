<?php

return [
    'create'        => [
        'title' => 'Nova Rolagem de Dados',
    ],
    'destroy'       => [
        'dice_roll' => 'Rolagem de dados removida',
    ],
    'edit'          => [],
    'fields'        => [
        'created_at'    => 'Rolado em',
        'parameters'    => 'Parâmetros',
        'results'       => 'Resultados',
        'rolls'         => 'Rolagens',
    ],
    'hints'         => [
        'parameters'    => 'Quais opções de dados estão disponíveis?',
    ],
    'index'         => [
        'actions'   => [
            'dice'      => 'Rolagem de Dados',
            'results'   => 'Resultados',
        ],
    ],
    'placeholders'  => [
        'dice_roll' => 'Rolagem de Dados',
        'name'      => 'Nome da Rolagem de Dados',
        'parameters'=> '4d6+3',
    ],
    'results'       => [
        'actions'   => [
            'add'   => 'Rolagem',
        ],
        'error'     => 'Rolagem de dados mal sucedida. Não é possível analisar os parâmetros.',
        'fields'    => [
            'creator'   => 'Criador',
            'date'      => 'Data',
            'result'    => 'Resultado',
        ],
        'hint'      => 'Todas as rolagens feitas para este modelo de rolagem de dados.',
        'success'   => 'Dados rolados.',
    ],
    'show'          => [
        'tabs'  => [
            'results'   => 'Resultados',
        ],
    ],
];
