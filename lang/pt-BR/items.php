<?php

return [
    'create'        => [
        'title' => 'Criar um novo item',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character'     => 'Criador',
        'is_equipped'   => 'Equipado',
        'price'         => 'Preço',
        'size'          => 'Tamanho',
        'weight'        => 'Peso',
    ],
    'helpers'       => [],
    'hints'         => [
        'items' => 'Organize os itens usando o campo de item primário.',
    ],
    'index'         => [],
    'inventories'   => [],
    'placeholders'  => [
        'price' => 'Preço do item',
        'size'  => 'Tamanho, Peso, Dimensões',
        'type'  => 'Arma, Poção, Artefato',
        'weight'=> 'Peso do item',
    ],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'Inventários',
        ],
    ],
];
