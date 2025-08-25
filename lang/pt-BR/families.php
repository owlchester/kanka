<?php

return [
    'create'        => [
        'title' => 'Nova Família',
    ],
    'destroy'       => [],
    'edit'          => [],
    'families'      => [],
    'fields'        => [],
    'helpers'       => [],
    'hints'         => [
        'is_extinct'    => 'Essa família está extinta.',
        'members'       => 'Os membros de uma família estão listados aqui. Um personagem pode ser adicionado a uma família editando o personagem desejado e usando a lista suspensa "Família".',
    ],
    'index'         => [],
    'members'       => [
        'create'    => [
            'helper'    => 'Adicione um ou vários membros a :name.',
            'success'   => '{0} Nenhum membro foi adicionado.|{1} 1 membro foi adicionado.|[2,*] :count membros foram adicionados.',
            'title'     => 'Novos Membros',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Nome da família',
        'type'  => 'Realeza, Nobres, Extinta',
    ],
    'show'          => [
        'tabs'  => [
            'tree'  => 'Árvore genealógica',
        ],
    ],
];
