<?php

return [
    'create'        => [
        'title' => 'Nova Família',
    ],
    'destroy'       => [],
    'edit'          => [],
    'families'      => [
        'title' => 'Famílias da Família :name',
    ],
    'fields'        => [
        'families'  => 'Sub-Famílias',
        'family'    => 'Família Primária',
        'members'   => 'Membros',
    ],
    'helpers'       => [
        'descendants'       => 'Esta lista contém todas as famílias que são descendentes desta família, e não apenas aquelas diretamente relacionadas a ela.',
        'nested_without'    => 'Exibindo todas as famílias que não tem uma família primária. Clique em uma linha para ver as famílias secundárias.',
    ],
    'hints'         => [
        'members'   => 'Os membros de uma família estão listados aqui. Um personagem pode ser adicionado a uma família editando o personagem desejado e usando a lista suspensa "Família".',
    ],
    'index'         => [],
    'members'       => [
        'helpers'   => [
            'all_members'       => 'A lista a seguir são todos os personagens que estão nesta família e todas as famílias descendentes da família.',
            'direct_members'    => 'A maioria das famílias tem membros que a administram ou a tornaram famosa. A lista a seguir são personagens que estão diretamente nesta família.',
        ],
        'title'     => 'Membros da Família :name',
    ],
    'placeholders'  => [
        'location'  => 'Escolha um local',
        'name'      => 'Nome da família',
        'type'      => 'Realeza, Nobres, Extinta',
    ],
    'show'          => [
        'tabs'  => [
            'all_members'   => 'Todos os Membros',
            'families'      => 'Famílias',
            'members'       => 'Membros',
        ],
    ],
];
