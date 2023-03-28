<?php

return [
    'characters'    => [
        'helpers'   => [
            'all_characters'    => 'Exibindo todos os personagens relacionados a esta raça e suas sub-raças.',
            'characters'        => 'Exibindo todos os personagens relacionados diretamente a esta raça.',
        ],
        'title'     => 'Personagens da Raça :name',
    ],
    'create'        => [
        'title' => 'Nova Raça',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'characters'    => 'Personagens',
        'locations'     => 'Locais',
        'race'          => 'Raça Primária',
        'races'         => 'Sub-Raças',
    ],
    'helpers'       => [
        'nested_without'    => 'Exibindo todas as raças que não tem uma raça primária. Clique em uma linha para ver as raças secundárias.',
    ],
    'index'         => [],
    'placeholders'  => [
        'name'  => 'Nome da raça',
        'type'  => 'Humano, Fada, Ciborgue',
    ],
    'races'         => [
        'title' => 'Sub-raças da Raça :name',
    ],
    'show'          => [
        'tabs'  => [
            'characters'    => 'Personagens',
            'races'         => 'Sub-raças',
        ],
    ],
];
