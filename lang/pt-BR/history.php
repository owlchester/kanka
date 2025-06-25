<?php

return [
    'actions'   => [
        'show-old'  => 'Alterações',
    ],
    'cta'       => 'Exiba um log de todas as alterações recentes na campanha.',
    'empty'     => 'Vazio',
    'fields'    => [
        'action'    => 'Ação',
        'details'   => 'Detalhes',
        'module'    => 'Módulo',
        'when'      => 'Quando',
        'who'       => 'Quem',
    ],
    'filters'   => [
        'all-actions'   => 'Todas as ações',
        'all-users'     => 'Todos os membros',
        'no-results'    => 'Nenhum resultado para exibir. Tente com outros filtros ou volte depois de fazer alterações nas entidades da campanha.',
    ],
    'helpers'   => [
        'base'      => 'Essa interface contém alterações recentes nas entidades da campanha por até :amount meses, mostrando as alterações mais recentes primeiro.',
        'changes'   => 'Os campos a seguir tinham anteriormente esses valores.',
    ],
    'log'       => [
        'create'        => ':user criou :entity',
        'create_post'   => ':user criou o post ":post" em :entity',
        'delete'        => ':user removeu :entity',
        'delete_post'   => ':user removeu um post em :entity',
        'reorder_post'  => ':user reordenou os posts de :entity',
        'restore'       => ':user restaurou :entity',
        'update'        => ':user atualizou :entity',
        'update_post'   => ':user atualizou o post ":post" em :entity',
    ],
    'title'     => 'Histórico',
    'unknown'   => [
        'entity'    => 'uma entidade desconhecida',
    ],
];
