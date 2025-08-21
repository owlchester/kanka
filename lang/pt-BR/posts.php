<?php

return [
    'create'        => [
        'template'  => [
            'helper'    => 'Os administradores da campanha definiram os seguintes posts como modelos que podem ser reutilizados.',
        ],
        'title'     => 'Novo Post',
    ],
    'fields'        => [
        'name'  => 'Nome',
    ],
    'helpers'       => [
        'new'           => 'Adicione um novo post a essa entidade.',
        'visibility'    => 'Altere a visibilidade do post :name.',
    ],
    'move'          => [
        'copy'      => [
            'helper'    => 'Mantenha uma cópia do post em :name.',
        ],
        'helper'    => 'Mova ou copie o post :name para uma entidade diferente.',
        'title'     => 'Mover post',
    ],
    'permissions'   => [
        'actions'   => [
            'members'   => 'Adicionar membros',
            'roles'     => 'Adicionar funções',
        ],
        'helpers'   => [
            'members'   => 'Adicione um ou vários membros para ter permissões especiais neste post.',
            'roles'     => 'Adicione uma ou várias funções para ter permissões especiais neste post.',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Nome do post',
    ],
    'position'      => [
        'dont_change'   => 'Não mude',
        'first'         => 'Primeiro',
        'last'          => 'Último',
    ],
    'remove'        => [
        'title' => 'Excluir post',
    ],
    'visibility'    => [
        'helper'    => 'Alterar a visibilidade para o post :name',
        'title'     => 'Visibilidade do post',
    ],
];
