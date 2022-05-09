<?php

return [
    'create'        => [
        'success'   => 'Família \':name\' criada.',
        'title'     => 'Criar nova família',
    ],
    'destroy'       => [
        'success'   => 'Família \':name\' removida.',
    ],
    'edit'          => [
        'success'   => 'Família \':name\' atualizada.',
        'title'     => 'Editar Família :name',
    ],
    'families'      => [
        'title' => 'Famílias da família :name',
    ],
    'fields'        => [
        'families'  => 'Sub famílias',
        'family'    => 'Família Principal',
        'image'     => 'Imagem',
        'location'  => 'Local',
        'members'   => 'Membros',
        'name'      => 'Nome',
        'type'      => 'Tipo',
    ],
    'helpers'       => [
        'descendants'   => 'Esta lista contém todas as famílias que são descendentes desta família, e não apenas aquelas diretamente relacionadas a ela.',
        'nested_parent' => 'Mostrando as famílias de :parent.',
        'nested_without'=> 'Mostrando todas as famílias que não tem uma família-pai. Clique em uma linha para ver as famílias-filhos.',
    ],
    'hints'         => [
        'members'   => 'Os membros de uma família estão listados aqui. Um personagem pode ser adicionado a uma família editando o personagem desejado e usando a lista suspensa "Família".',
    ],
    'index'         => [
        'title' => 'Famílias',
    ],
    'members'       => [
        'helpers'   => [
            'all_members'       => 'A lista a seguir são todos os personagens que estão nesta família e todas as subfamílias dela.',
            'direct_members'    => 'A maioria das famílias tem membros que a administram ou a tornaram famosa. A lista a seguir são personagens que estão diretamente nesta família.',
        ],
        'title'     => 'Membros da família :name',
    ],
    'placeholders'  => [
        'location'  => 'Escolha um local',
        'name'      => 'Nome da família',
        'type'      => 'Realeza, Nobres, Extinta',
    ],
    'show'          => [
        'tabs'  => [
            'all_members'   => 'Todos membros',
            'families'      => 'Famílias',
            'members'       => 'Membros',
        ],
    ],
];
