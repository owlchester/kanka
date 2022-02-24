<?php

return [
    'create'        => [
        'success'       => 'Item \':name\' criado',
        'title'         => 'Criar um novo item',
    ],
    'destroy'       => [
        'success'   => 'Item \':name\' removido',
    ],
    'edit'          => [
        'success'   => 'Item \':name\' atualizado',
        'title'     => 'Editar Item :name',
    ],
    'fields'        => [
        'character' => 'Personagem',
        'image'     => 'Imagem',
        'location'  => 'Local',
        'name'      => 'Nome',
        'price'     => 'Preço',
        'relation'  => 'Relação',
        'size'      => 'Tamanho',
        'type'      => 'Tipo',
    ],
    'index'         => [
        'add'           => 'Novo Item',
        'header'        => 'Itens de :name',
        'title'         => 'Itens',
    ],
    'inventories'   => [
        'title'         => 'Item :name inventários',
    ],
    'placeholders'  => [
        'character' => 'Escolha um personagem',
        'location'  => 'Escolha um local',
        'name'      => 'Nome do item',
        'price'     => 'Preço do item',
        'size'      => 'Tamanho, Peso, Dimensões',
        'type'      => 'Arma, Poção, Artefato',
    ],
    'show'          => [
        'tabs'          => [
            'information'   => 'Informações',
            'inventories'   => 'Inventários',
            'quests'        => 'Missões',
        ],
        'title'         => 'Item :name',
    ],
];
