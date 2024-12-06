<?php

return [
    'create'        => [
        'title' => 'Nova Família',
    ],
    'destroy'       => [],
    'edit'          => [],
    'families'      => [],
    'fields'        => [
        'members'   => 'Membros',
    ],
    'helpers'       => [],
    'hints'         => [
        'is_extinct'    => 'Essa família está extinta.',
        'members'       => 'Os membros de uma família estão listados aqui. Um personagem pode ser adicionado a uma família editando o personagem desejado e usando a lista suspensa "Família".',
    ],
    'index'         => [],
    'members'       => [
        'create'    => [
            'submit'    => 'Adicionar membros',
            'success'   => '{0} Nenhum membro foi adicionado.|{1} 1 membro foi adicionado.|[2,*] :count membros foram adicionados.',
            'title'     => 'Novos Membros',
        ],
        'helpers'   => [
            'all_members'       => 'A lista a seguir são todos os personagens que estão nesta família e todas as famílias descendentes da família.',
            'direct_members'    => 'A maioria das famílias tem membros que a administram ou a tornaram famosa. A lista a seguir são personagens que estão diretamente nesta família.',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Nome da família',
        'type'  => 'Realeza, Nobres, Extinta',
    ],
    'show'          => [
        'tabs'  => [
            'members'   => 'Membros',
            'tree'      => 'Árvore genealógica',
        ],
    ],
];
