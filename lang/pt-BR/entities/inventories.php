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
        'amount'            => 'Quantidade',
        'copy_entity_entry' => 'Usar a entrada do item',
        'description'       => 'Descrição',
        'is_equipped'       => 'Equipado',
        'name'              => 'Nome',
        'position'          => 'Posição',
        'qty'               => 'Qtd',
    ],
    'helpers'       => [
        'copy_entity_entry' => 'Exibe a entrada do item ao invés da descrição personalizada.',
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
    'update'        => [
        'success'   => 'Item :item de :entity atualizado.',
        'title'     => 'Atualizar o item de :name',
    ],
];
