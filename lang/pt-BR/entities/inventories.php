<?php

return [
    'actions'           => [
        'add'               => 'Adicionar item',
        'copy_from'         => 'Copiar de',
        'copy_inventory'    => 'Copiar inventário',
    ],
    'copy'              => [
        'helper'    => 'Copiar o inventário inteiro de uma entidade para :name',
    ],
    'create'            => [
        'helper'        => 'Adicione um item ao inventário de :name. Opcionalmente, ele pode ser vinculado a um objeto existente da campanha.',
        'success'       => 'Item :item adicionado a :entity.',
        'success_bulk'  => '{0} Nenhum item adicionado à :entity.|{1} :count item adicionado à :entity.|[2,*] :count itens adicionados à :entity.',
        'title'         => 'Adicionar um item a :name',
    ],
    'default_position'  => 'Desorganizado',
    'destroy'           => [
        'success'           => 'Item :item removido de :entuty.',
        'success_position'  => 'Itens em :position removidos de :entity.',
    ],
    'fields'            => [
        'amount'                => 'Quantidade',
        'copy_entity_entry_v2'  => 'Usar introdução do objeto',
        'description'           => 'Descrição',
        'is_equipped'           => 'Equipado',
        'name'                  => 'Nome',
        'position'              => 'Posição',
        'qty'                   => 'Qtd',
    ],
    'helpers'           => [
        'amount'                => 'Número de itens',
        'copy_entity_entry_v2'  => 'Exiba a introdução do objeto em vez da descrição personalizada.',
        'description'           => 'Adicione uma descrição personalizada ao item',
        'is_equipped'           => 'Marque estes itens como equipados.',
        'name'                  => 'Dê o nome ao item. Um nome é necessário se nenhum objeto for selecionado',
    ],
    'placeholders'      => [
        'amount'        => 'Qualquer quantidade',
        'description'   => 'Usado, Danificado, Sintonizado',
        'name'          => 'Obrigatório se nenhum item for selecionado',
        'position'      => 'Equipado, Mochila, Estoque, Banco',
    ],
    'show'              => [
        'helper'    => 'Para criar o inventário desta entidade, comece adicionando um item a ele.',
        'title'     => 'Inventário :name',
        'unsorted'  => 'Não classificado',
    ],
    'tooltips'          => [
        'equipped'  => 'Este item está equipado',
    ],
    'tutorials'         => [
        'character' => 'Acompanhe o que :name possui ou tem para vender adicionando itens ao seu inventário.',
        'location'  => 'Acompanhe o que :name tem para vender ou saquear adicionando itens ao seu inventário.',
        'other'     => 'Acompanhe o que :name possui adicionando itens ao seu inventário.',
    ],
    'update'            => [
        'success'   => 'Item :item de :entity atualizado.',
        'title'     => 'Atualizar o item de :name',
    ],
];
