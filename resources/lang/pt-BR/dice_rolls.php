<?php

return [
    'create'        => [
        'description'   => 'Criar uma nova rolagem de dados',
        'success'       => 'Rolagem de dados :name: criada',
        'title'         => 'Nova rolagem de dados',
    ],
    'destroy'       => [
        'dice_roll' => 'Rolagem de dados removida',
        'success'   => 'Rolagem de dados :name removida',
    ],
    'edit'          => [
        'description'   => 'Editar uma rolagem de dados',
        'success'       => 'Rolagem de dados :name atualizada',
        'title'         => 'Editar rolagem de dados :name',
    ],
    'fields'        => [
        'created_at'    => 'Rolado em',
        'name'          => 'Nome',
        'parameters'    => 'Parâmetros',
        'results'       => 'Resultados',
        'rolls'         => 'Rolagens',
    ],
    'hints'         => [
        'parameters'    => 'Quais são mimnhas opções de dados?',
    ],
    'index'         => [
        'actions'       => [
            'dice'      => 'Rolagem de dados',
            'results'   => 'Resultados',
        ],
        'add'           => 'Nova rolagem de dados',
        'description'   => 'Gerenciar rolagens de dado de :name',
        'header'        => 'Rolagens de dado de :name',
        'title'         => 'Rolagens de dado',
    ],
    'placeholders'  => [
        'dice_roll' => 'Rolagem de dados',
        'name'      => 'Nome da rolagem de dados',
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
        'success'   => 'Dados rolados',
    ],
    'show'          => [
        'description'   => 'Uma vista detalhada de uma rolagem de dados',
        'tabs'          => [
            'results'   => 'Resultados',
        ],
        'title'         => 'Rolagem de dados :name',
    ],
];
