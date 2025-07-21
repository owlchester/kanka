<?php

return [
    'create'        => [
        'title' => 'Nova Organização',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_defunct'    => 'Extinta',
        'members'       => 'Membros',
    ],
    'helpers'       => [],
    'hints'         => [
        'is_defunct'    => 'Esta organização está extinta.',
    ],
    'index'         => [],
    'members'       => [
        'actions'       => [
            'add_multiple'  => 'Adicionar membros',
        ],
        'create'        => [
            'helper'            => 'Adicionar um ou vários membros à :name.',
            'success_multiple'  => '{1} Adicionado :count membro a :name.|[2,*] Adicionados :count membros a :name.',
        ],
        'destroy'       => [
            'success'   => 'Membro removido da organização.',
        ],
        'edit'          => [
            'title' => 'Atualizar Membro para :name',
        ],
        'fields'        => [
            'parent'    => 'Superior',
            'pinned'    => 'Fixado',
            'role'      => 'Função',
            'status'    => 'Status de Afiliação',
        ],
        'helpers'       => [
            'all_members'   => 'Todos personagens que são membros desta organização e suas sub-organizações.',
            'members'       => 'Todos personagens que são membros desta organização.',
            'pinned'        => 'Escolha se este membro deve ser exibido na seção fixada da visão geral de suas entidades associadas.',
        ],
        'pinned'        => [
            'both'  => 'Fixado em ambos',
            'none'  => 'Fixado em nenhum lugar',
        ],
        'placeholders'  => [
            'parent'    => 'Quem é o superior desse membro',
            'role'      => 'Líder, Membro, Alto Septão, Mestre em Espionagem',
        ],
        'status'        => [
            'active'    => 'Membro ativo',
            'inactive'  => 'Membro inativo',
            'unknown'   => 'Status desconhecido',
        ],
    ],
    'organisations' => [],
    'placeholders'  => [
        'type'  => 'Culto, Gangue, Rebelião, Fanáticos',
    ],
    'show'          => [],
];
