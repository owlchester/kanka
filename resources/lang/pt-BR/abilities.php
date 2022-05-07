<?php

return [
    'abilities'     => [
        'title' => 'Habilidades relacionadas a :name',
    ],
    'children'      => [
        'actions'       => [
            'add'   => 'Adicionar habilidade a entidade',
        ],
        'create'        => [
            'success'   => 'Adicionar a habilidade :name a entidade.',
            'title'     => 'Adicionar uma entidade a :name',
        ],
        'description'   => 'Entidades que possuem a habilidade',
        'title'         => 'Habilidade :name Entidades',
    ],
    'create'        => [
        'success'   => 'Habilidade \':name\' criada.',
        'title'     => 'Nova Habilidade',
    ],
    'destroy'       => [
        'success'   => 'Habilidade \':name\' removida.',
    ],
    'edit'          => [
        'success'   => 'Habilidade \':name\' atualizada.',
        'title'     => 'Editar habilidade :name',
    ],
    'entities'      => [
        'title' => 'Entidades com a habilidade :name',
    ],
    'fields'        => [
        'abilities' => 'Habilidades',
        'ability'   => 'Habilidade Principal',
        'charges'   => 'Cargas',
        'name'      => 'Nome',
        'type'      => 'Tipo',
    ],
    'helpers'       => [
        'descendants'   => 'Esta lista contém todas as habilidades que são descendentes dessa habilidade, e não apenas aquelas diretamente relacionadas a ela.',
        'nested_parent' => 'Mostrando as habilidades de :parent.',
        'nested_without'=> 'Mostrando todas as habilidades que não possuem uma habilidade-pai. Clique em uma linha para ver as habilidades-filhos.',
    ],
    'index'         => [
        'title' => 'Habilidades',
    ],
    'placeholders'  => [
        'charges'   => 'Quantidade de cargas. Atributos de referência com {Level} * {CHA}',
        'name'      => 'Bola de fogo, alerta, ataque astuto',
        'type'      => 'Feitiço, Talento, Ataque',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Habilidades',
            'entities'  => 'Entidades',
        ],
    ],
];
