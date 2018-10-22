<?php

return [
    'create'        => [
        'description'   => 'Criar uma nova família',
        'success'       => 'Família \':name\' criada.',
        'title'         => 'Criar nova família',
    ],
    'destroy'       => [
        'success'   => 'Família \':name\' removida.',
    ],
    'edit'          => [
        'success'   => 'Família \':name\' atualizada.',
        'title'     => 'Editar Família :name',
    ],
    'fields'        => [
        'image'     => 'Imagem',
        'location'  => 'Local',
        'members'   => 'Membros',
        'name'      => 'Nome',
        'relation'  => 'Relação',
    ],
    'index'         => [
        'add'           => 'Nova Família',
        'description'   => 'Gerencie as famílias de :name.',
        'header'        => 'Famílias de :name',
        'title'         => 'Famílias',
    ],
    'placeholders'  => [
        'location'  => 'Escolha um local',
        'name'      => 'Nome da família',
    ],
    'show'          => [
        'description'   => 'Uma visão detalhada de uma família',
        'tabs'          => [
            'member'    => 'Membros',
            'relation'  => 'Relações',
        ],
        'title'         => 'Família :name',
    ],
];
