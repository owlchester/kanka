<?php

return [
    'actions'       => [
        'add'   => 'Adicionar item',
    ],
    'create'        => [
        'success'   => 'Item :item adicionado a :entity',
        'title'     => 'Adicionar um item a :name',
    ],
    'destroy'       => [
        'success'   => 'Item :item removido de :entuty',
    ],
    'fields'        => [
        'amount'        => 'Quantidade',
        'description'   => 'Descrição',
        'is_equipped'   => 'Equipado',
        'name'          => 'Nome',
        'position'      => 'Posição',
    ],
    'placeholders'  => [
        'amount'        => 'Qualquer quantidade',
        'description'   => 'Usado, Danificado, Sintonizado',
        'name'          => 'Necessário se nenhum item estiver selecionado',
        'position'      => 'Equipado, na Mochila, Armazenamento, Banco',
    ],
    'show'          => [
        'helper'    => 'As entidades podem ter itens anexados a elas para criar um inventário.',
        'title'     => 'Inventário da entidade :name',
        'unsorted'  => 'Não classificado',
    ],
    'update'        => [
        'success'   => 'Item :item de :entity atualizado',
        'title'     => 'Atualizar o item em :name',
    ],
];
