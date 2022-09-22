<?php

return [
    'actions'       => [
        'copy'  => 'Copiar',
        'move'  => 'Mover',
    ],
    'errors'        => [
        'permission'        => 'Você não tem permissão para criar entidades desse tipo na campanha alvo.',
        'permission_update' => 'Você não tem permissão para mover essa entidade.',
        'same_campaign'     => 'Você precisa selecionar outra campanha para mover a entidade.',
        'unknown_campaign'  => 'Campanha desconhecida.',
    ],
    'fields'        => [
        'campaign'      => 'Campanha alvo',
        'copy'          => 'Fazer uma cópia',
        'select_one'    => 'Selecionar uma campanha',
    ],
    'panel'         => [
        'description'           => 'Selecione uma campanha que você deseja mover ou fazer uma cópia dessa entidade.',
        'description_bulk_copy' => 'Selecione uma campanha para qual você deseja copiar as entidades selecionadas.',
        'title'                 => 'Mover ou copiar uma entidade para outra campanha',
    ],
    'success'       => 'Entidade :name movida.',
    'success_copy'  => 'Entidade :entity copiada.',
    'title'         => 'Mover :name',
];
