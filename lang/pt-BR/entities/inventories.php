<?php

return [
    'actions'       => [
        'add'   => 'Adicionar item',
    ],
    'create'        => [
        'success'   => 'Item :item adicionado a :entity.',
        'title'     => 'Adicionar um item a :name',
    ],
    'destroy'       => [
        'success'   => 'Item :item removido de :entuty.',
    ],
    'fields'        => [
        'amount'        => 'Quantidade',
        'description'   => 'Descrição',
        'is_equipped'   => 'Equipado',
        'name'          => 'Nome',
        'position'      => 'Posição',
        'qty'           => 'Qtd',
    ],
    'helpers'       => [
        'is_equipped'   => 'Marque estes itens como equipados.',
    ],
    'placeholders'  => [
        'amount'        => 'Qualquer quantidade',
        'description'   => 'Usado, Danificado, Sintonizado',
        'name'          => 'Obrigatório se nenhum item for selecionado',
        'position'      => 'Equipado, Mochila, Estoque, Banco',
    ],
    'show'          => [
        'helper'    => 'Para criar o inventário desta entidade, comece adicionando um item a ele.',
        'title'     => 'Inventário :name',
        'unsorted'  => 'Não classificado',
    ],
    'tutorial'      => 'Acompanhe o que uma entidade processa adicionando itens ao seu inventário.',
    'update'        => [
        'success'   => 'Item :item de :entity atualizado.',
        'title'     => 'Atualizar o item de :name',
    ],
];
