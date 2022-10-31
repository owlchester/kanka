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
    'index'         => [],
    'inventories'   => [
        'title' => 'Item :name inventários',
    ],
    'placeholders'  => [
        'name'  => 'Nome do item',
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
