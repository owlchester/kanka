<?php

return [
    'children'      => [
        'actions'       => [
            'add'   => 'Adicionar nova tag',
        ],
        'create'        => [
            'title' => 'Adicionar uma tag a :name',
        ],
        'description'   => 'Entidades que pertencem à tag',
        'title'         => 'Tags secundárias da tag :name',
    ],
    'create'        => [
        'description'   => 'Criar nova tag',
        'success'       => 'Tag \':name\' criada.',
        'title'         => 'Nova tag',
    ],
    'destroy'       => [
        'success'   => 'Tag \':name\' removida',
    ],
    'edit'          => [
        'success'   => 'Tag \':name\' atualizada',
        'title'     => 'Editar tag :name',
    ],
    'fields'        => [
        'characters'    => 'Personagens',
        'children'      => 'Tags secundárias',
        'name'          => 'Nome',
        'tag'           => 'Tag Principal',
        'tags'          => 'Subtags',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'nested'    => 'Quando em visualização aninhada, você pode visualizar suas tags de uma maneira aninhada. Tags que não estão relacionadas a uma tag primária serão mostradas por padrão. As tags com tags secundárias podem ser clicadas para visualizar essas tags. Você pode continuar clicando até que não haja mais tags secundárias para ver.',
    ],
    'hints'         => [
        'children'  => 'Esta lista contém todas entidades diretamente relacionadas a esta tag e todas tags aninhadas nela.',
        'tag'       => 'Exibidas abaixo estão todas as tags diretamente relacionadas a ela.',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Visão Aninhada',
        ],
        'add'           => 'Nova tag',
        'description'   => 'Gerenciar a tag de :name',
        'header'        => 'Tags em :name',
        'title'         => 'Tags',
    ],
    'new_tag'       => 'Nova tag',
    'placeholders'  => [
        'name'  => 'Nome da tag',
        'tag'   => 'Escolha a Tag Principal',
        'type'  => 'Tradições, Guerras, História, Religião, Vexilologia',
    ],
    'show'          => [
        'description'   => 'Uma visão detalhada da tag',
        'tabs'          => [
            'children'      => 'Tags secundárias',
            'information'   => 'Informação',
            'tags'          => 'Tags',
        ],
        'title'         => 'Tag :name',
    ],
    'tags'          => [
        'description'   => 'Tags secundárias',
        'title'         => 'Tags secundárias da tag :name',
    ],
];
