<?php

return [
    'privacy'   => [
        'text'      => 'Esta entidade está definida como privada. Permissões personalizadas ainda podem ser definidas, mas enquanto a entidade for privada, elas serão ignoradas e somente os membros do cargo de :admin da campanha poderão ver a entidade.',
        'warning'   => 'Aviso',
    ],
    'quick'     => [
        'empty-permissions' => 'Nenhum cargo ou usuário além dos administradores da campanha tem acesso a esta entidade.',
        'field'             => 'Edição rápida',
        'options'           => [
            'private'   => 'Privado para todos, exceto administradores',
            'visible'   => 'Visível para o seguinte',
        ],
        'private'           => 'Somente membros do cargo de administrador da campanha pode atualmente ver essa entidade.',
        'public'            => 'Essa entidade é atualmente visível a qualquer usuário ou cargo com acesso a ela.',
        'success'           => [
            'private'   => ':entity está agora escondida.',
            'public'    => ':entity está agora visível.',
        ],
        'title'             => 'Visão geral da permissão',
        'viewable-by'       => 'Visível por',
    ],
];
