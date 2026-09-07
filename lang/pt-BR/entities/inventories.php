<?php

return [
    'actions'           => [
        'copy_from_entity'  => 'Copiar de outra entidade',
        'copy_inventory'    => 'Copiar inventário',
        'generate'          => 'Gerar',
        'multiple'          => 'Adicionar itens',
    ],
    'copy'              => [
        'helper'    => 'Copiar o inventário inteiro de uma entidade para :name',
    ],
    'create'            => [
        'helper'        => 'Adicione um item ao inventário de :name. Opcionalmente, ele pode ser vinculado a um objeto existente da campanha.',
        'success'       => 'Item :item adicionado a :entity.',
        'success_bulk'  => '{0} Nenhum item adicionado à :entity.|{1} :count item adicionado à :entity.|[2,*] :count itens adicionados à :entity.',
        'title'         => 'Adicionar ao inventário',
    ],
    'default_position'  => 'Desorganizado',
    'destroy'           => [
        'success'           => 'Item :item removido de :entity.',
        'success_position'  => 'Itens em :position removidos de :entity.',
    ],
    'fields'            => [
        'amount'                => 'Quantidade',
        'copy_entity_entry_v2'  => 'Usar introdução do objeto',
        'description'           => 'Descrição',
        'is_equipped'           => 'Equipado',
        'item_amount'           => 'Número de itens',
        'match_all'             => 'Corresponder a todas as tags',
        'name'                  => 'Nome',
        'position'              => 'Posição',
        'qty'                   => 'Qtd',
        'replace'               => 'Substituir inventário',
    ],
    'generate'          => [
        'helper'    => 'Gere um inventário para :name com base nos itens existentes na campanha.',
        'title'     => 'Gerar inventário',
    ],
    'helpers'           => [
        'amount'                => 'Número de itens',
        'copy_entity_entry_v2'  => 'Exiba a introdução do objeto em vez da descrição personalizada.',
        'description'           => 'Adicione uma descrição personalizada ao item',
        'is_equipped'           => 'Marque estes itens como equipados.',
        'name'                  => 'Dê o nome ao item. Um nome é necessário se nenhum objeto for selecionado',
        'replace'               => 'Substitui o inventário atual pelo inventário gerado.',
    ],
    'placeholders'      => [
        'amount'        => 'Qualquer quantidade',
        'description'   => 'Usado, Danificado, Sintonizado',
        'name'          => 'Saco de dormir',
        'position'      => 'Equipado, Mochila, Estoque, Banco',
    ],
    'show'              => [
        'helper'    => 'Para criar o inventário desta entidade, comece adicionando um item a ele.',
        'title'     => 'Inventário de :name',
        'unsorted'  => 'Não classificado',
    ],
    'togglers'          => [
        'hide'  => [
            'price'     => 'Esconder preço',
            'quantity'  => 'Esconder quantidade',
            'size'      => 'Esconder tamanho',
            'weight'    => 'Esconder peso',
        ],
        'show'  => [
            'price'     => 'Exibir preço',
            'quantity'  => 'Exibir quantidade',
            'size'      => 'Exibir tamanho',
            'weight'    => 'Exibir peso',
        ],
    ],
    'tooltips'          => [
        'equipped'  => 'Este item está equipado',
    ],
    'tutorials'         => [
        'all'   => 'Acompanhe o que :name possui, armazena ou oferece adicionando itens a este inventário.',
    ],
    'update'            => [
        'success'   => 'Item :item de :entity atualizado.',
        'title'     => 'Atualizar o item de :name',
    ],
];
