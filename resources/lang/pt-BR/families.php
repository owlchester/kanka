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
        'relation'  => 'Relação',
        'type'      => 'Tipo',
    ],
    'helpers'       => [
        'descendants'   => 'Esta lista contém todas as famílias que são descendentes desta família, e não apenas aquelas diretamente relacionadas a ela.',
        'nested'        => 'Quando na Visão Aninhada, você pode ver suas Famílias de uma maneira aninhada. Famílias que não são parte de uma Família Principal serão mostradas por padrão. Famílias com subfamílias podem ser clicadas para ver essas subfamílias. Você pode continuar clicando até que não haja mais subfamílias para ver.',
    ],
    'hints'         => [
        'members'   => 'Os membros de uma família estão listados aqui. Um personagem pode ser adicionado a uma família editando o personagem desejado e usando a lista suspensa "Família".',
    ],
    'index'         => [
        'add'           => 'Nova Família',
        'description'   => 'Gerencie as famílias de :name.',
        'header'        => 'Famílias de :name',
        'title'         => 'Famílias',
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
        'description'   => 'Uma visão detalhada de uma família',
        'tabs'          => [
            'all_members'   => 'Todos membros',
            'families'      => 'Famílias',
            'members'       => 'Membros',
            'relation'      => 'Relações',
        ],
        'title'         => 'Família :name',
    ],
];
