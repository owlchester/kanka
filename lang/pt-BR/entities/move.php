<?php

return [
    'actions'       => [
        'copy'  => 'Copiar',
    ],
    'errors'        => [
        'permission'        => 'Você não tem permissão para criar entidades desse tipo na campanha alvo.',
        'permission_update' => 'Você não tem permissão para mover essa entidade.',
        'same_campaign'     => 'Você precisa selecionar outra campanha para mover a entidade.',
        'unknown_campaign'  => 'Campanha desconhecida.',
    ],
    'fields'        => [
        'campaign'      => 'Campanha alvo',
        'copy'          => 'Criar uma cópia na campanha alvo',
        'select_one'    => 'Selecionar uma campanha',
    ],
    'helpers'       => [
        'copy'  => 'Crie uma cópia da entidade na campanha de destino.',
    ],
    'panel'         => [
        'description'           => 'Selecione uma campanha que você deseja mover ou fazer uma cópia dessa entidade.',
        'description_bulk_copy' => 'Selecione uma campanha para qual você deseja copiar as entidades selecionadas.',
        'title'                 => 'Mover ou copiar uma entidade para outra campanha',
    ],
    'success'       => 'Entidade :name movida.',
    'success_copy'  => 'Entidade :entity copiada.',
    'title'         => 'Mover :name',
    'warnings'      => [
        'custom'    => 'Esta entidade não é de um módulo padrão, mas sim de um tipo de entidade personalizado ":module". Ela será criada como uma entidade de Nota na campanha de destino.',
    ],
];
