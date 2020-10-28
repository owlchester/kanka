<?php

return [
    'create'        => [
        'description'   => 'Criar um novo item',
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
        'description'   => 'Gerencie os itens de :name.',
        'header'        => 'Itens de :name',
        'title'         => 'Itens',
    ],
    'inventories'   => [
        'description'   => 'Inventários da entidade na qual o item está.',
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
    'quests'        => [
        'description'   => 'Missões das quais este item faz parte',
        'title'         => 'Missões do item :name',
    ],
    'show'          => [
        'description'   => 'Uma visão detalhada de um item',
        'tabs'          => [
            'information'   => 'Informações',
            'inventories'   => 'Inventários',
            'quests'        => 'Missões',
        ],
        'title'         => 'Item :name',
    ],
];
