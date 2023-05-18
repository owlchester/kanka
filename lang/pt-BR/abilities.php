<?php

return [
    'abilities'     => [],
    'children'      => [
        'actions'       => [
            'add'   => 'Adicionar habilidade para entidade',
        ],
        'create'        => [
            'success'   => 'Habilidade :name adicionada para a entidade.',
            'title'     => 'Adicionar uma entidade a :name',
        ],
        'description'   => 'Entidades que possuem a habilidade',
        'title'         => 'Entidades com a Habilidade :name',
    ],
    'create'        => [
        'title' => 'Nova Habilidade',
    ],
    'destroy'       => [],
    'edit'          => [],
    'entities'      => [],
    'fields'        => [
        'charges'   => 'Cargas',
    ],
    'helpers'       => [
        'nested_without'    => 'Exibindo todas as habilidades que não possuem uma habilidade primária. Clique em uma linha para ver as habilidades secundárias.',
    ],
    'index'         => [],
    'placeholders'  => [
        'charges'   => 'Quantidade de cargas. Atributos de referência com {Level} * {CHA}',
        'name'      => 'Bola de Fogo, Alerta, Ataque Astuto',
        'type'      => 'Magia, Talento, Ataque',
    ],
    'reorder'       => [
        'parentless'    => 'Sem Habilidade Primária',
        'success'       => 'Habilidades reordenadas com sucesso.',
        'title'         => 'Reordenar as habilidades',
    ],
    'show'          => [
        'tabs'  => [
            'entities'  => 'Entidades',
            'reorder'   => 'Reordenar Habilidades',
        ],
    ],
];
