<?php

return [
    'characters'    => [
        'helpers'   => [
            'all_characters'    => 'Mostrando todos os personagens relacionados a esta raça e suas sub-raças',
            'characters'        => 'Mostrando todos os personagens relacionados diretamente a esta raça.',
        ],
        'title'     => 'Raça :name Personagens',
    ],
    'create'        => [
        'success'   => 'Raça \':name\' criada',
        'title'     => 'Nova Raça',
    ],
    'destroy'       => [
        'success'   => 'Raça \':name\' removida',
    ],
    'edit'          => [
        'success'   => 'Raça \':name\' atualizada',
        'title'     => 'Editar raça :name',
    ],
    'fields'        => [
        'characters'    => 'Personagens',
        'name'          => 'Nome',
        'race'          => 'Raça Ancestral',
        'races'         => 'Sub-raças',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'nested_parent' => 'Mostrando as raças de :parent.',
        'nested_without'=> 'Mostrando todas as raças que não tem uma raça-pai. Clique em uma linha para ver as raças-filhos.',
    ],
    'index'         => [
        'title' => 'Raças',
    ],
    'placeholders'  => [
        'name'  => 'Nome da raça',
        'type'  => 'Humano, Fada, Ciborgue',
    ],
    'races'         => [
        'title' => 'Raça :name sub-raças',
    ],
    'show'          => [
        'tabs'  => [
            'characters'    => 'Personagens',
            'races'         => 'Sub-raças',
        ],
    ],
];
