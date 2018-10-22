<?php

return [
    'create'        => [
        'description'   => 'Criar uma nova organização',
        'success'       => 'Organização \':name\' criada.',
        'title'         => 'Criar nova organização',
    ],
    'destroy'       => [
        'success'   => 'Organização \':name\' removida.',
    ],
    'edit'          => [
        'success'   => 'Organização \':name\' atualizada.',
        'title'     => 'Editar Organização :name',
    ],
    'fields'        => [
        'image'     => 'Imagem',
        'location'  => 'Local',
        'members'   => 'Membros',
        'name'      => 'Nome',
        'relation'  => 'Relação',
        'type'      => 'Tipo',
    ],
    'index'         => [
        'add'           => 'Nova Organização',
        'description'   => 'Gerencie as organizações de :name.',
        'header'        => 'Organizações de :name',
        'title'         => 'Organizações',
    ],
    'members'       => [
        'actions'       => [
            'add'   => 'Adicionar um membro',
        ],
        'create'        => [
            'description'   => 'Adicionar um membro à organização',
            'success'       => 'Membro adicionado à organização',
            'title'         => 'Novo Membro da Organização para :name',
        ],
        'destroy'       => [
            'success'   => 'Membro removido da organização',
        ],
        'edit'          => [
            'success'   => 'Membro da organização atualizado.',
            'title'     => 'Atualizar Membro para :name',
        ],
        'fields'        => [
            'character' => 'Personagem',
            'role'      => 'Função',
        ],
        'placeholders'  => [
            'character' => 'Escolha um personagem',
            'role'      => 'Líder, Membro, Alto Septão, Mestre em Espionagem',
        ],
    ],
    'placeholders'  => [
        'location'  => 'Escolha um local',
        'name'      => 'Nome da organização',
        'type'      => 'Culto, Gangue, Rebelião, Fanáticos',
    ],
    'show'          => [
        'description'   => 'Uma visão detalhada de uma organização',
        'tabs'          => [
            'members'   => 'Membros',
            'relations' => 'Relações',
        ],
        'title'         => 'Organização :name',
    ],
];
