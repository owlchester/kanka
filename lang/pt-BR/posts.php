<?php

return [
    'create'        => [
        'title' => 'Novo Artigo',
    ],
    'fields'        => [
        'description'   => 'Descrição',
        'layout'        => 'Layout do artigo',
        'name'          => 'Nome do artigo',
    ],
    'helpers'       => [
        'new'           => 'Adicione um novo artigo a essa entidade.',
        'visibility'    => 'Altere a visibilidade do artigo :name.',
    ],
    'move'          => [
        'copy'      => [
            'helper'    => 'Mantenha uma cópia do artigo em :name.',
        ],
        'helper'    => 'Mova ou copie o artigo :name para uma entidade diferente.',
        'title'     => 'Mover artigo',
    ],
    'permissions'   => [
        'actions'   => [
            'members'   => 'Adicionar membros',
            'roles'     => 'Adicionar funções',
        ],
        'helpers'   => [
            'members'   => 'Adicione um ou vários membros para ter permissões especiais neste artigo.',
            'roles'     => 'Adicione uma ou várias funções para ter permissões especiais neste artigo.',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Nome do artigo',
    ],
    'position'      => [
        'dont_change'   => 'Não mude',
        'first'         => 'Primeiro',
        'last'          => 'Último',
    ],
    'remove'        => [
        'title' => 'Excluir artigo',
    ],
    'visibility'    => [
        'helper'    => 'Alterar a visibilidade para o artigo :name',
        'title'     => 'Visibilidade do artigo',
    ],
];
