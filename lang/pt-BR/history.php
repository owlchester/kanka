<?php

return [
    'actions'   => [
        'show-old'  => 'Mudanças',
    ],
    'cta'       => 'Exiba um log de todas as alterações recentes na campanha.',
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
        'create'    => ':user criou :entity',
        'delete'    => ':user deletou :entity',
        'restore'   => ':user restaurou :entity',
        'update'    => ':user atualizou :entity',
    ],
    'title'     => 'Histórico',
    'unknown'   => [
        'entity'    => 'uma entidade desconhecida',
    ],
];
