<?php

return [
    'create'        => [
        'title' => 'Criar um novo item',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character' => 'Criador',
        'image'     => 'Imagem',
        'location'  => 'Local',
        'name'      => 'Nome',
        'price'     => 'Preço',
        'size'      => 'Tamanho',
        'type'      => 'Tipo',
    ],
    'index'         => [
        'title' => 'Itens',
    ],
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
