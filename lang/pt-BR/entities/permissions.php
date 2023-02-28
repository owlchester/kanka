<?php

return [
    'privacy'   => [
        'text'      => 'Esta entidade está definida como privada. Permissões personalizadas ainda podem ser definidas, mas enquanto a entidade for privada, elas serão ignoradas e somente os membros da função :admin da campanha poderão ver a entidade.',
        'warning'   => 'Aviso',
    ],
    'quick'     => [
        'empty-permissions' => 'Nenhuma função ou usuário além dos administradores da campanha tem acesso a esta entidade.',
        'field'             => 'Edição rápida',
        'options'           => [
            'private'   => 'Privado para todos, exceto administradores',
            'visible'   => 'Visível para o seguinte',
        ],
        'success'           => [
            'private'   => ':entity está agora escondida.',
            'public'    => ':entity está agora visível.',
        ],
        'viewable-by'       => 'Visível por',
    ],
];
