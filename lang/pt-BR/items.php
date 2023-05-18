<?php

return [
    'create'        => [
        'title' => 'Criar um novo item',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character' => 'Criador',
        'price'     => 'Preço',
        'size'      => 'Tamanho',
    ],
    'helpers'       => [
        'nested_without'    => 'Exibindo todos os itens que não possuem um item primário. Clique em uma linha para ver os itens secundários.',
    ],
    'hints'         => [
        'items' => 'Organize os itens usando o campo de item primário.',
    ],
    'index'         => [],
    'inventories'   => [],
    'placeholders'  => [
        'price' => 'Preço do item',
        'size'  => 'Tamanho, Peso, Dimensões',
        'type'  => 'Arma, Poção, Artefato',
    ],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Inventários',
        ],
    ],
];
