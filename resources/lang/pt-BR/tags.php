<?php

return [
    'children'      => [
        'actions'   => [
            'add'   => 'Adicionar à tag',
        ],
        'create'    => [
            'success'   => 'Adicionada a tag :name a entidade.',
            'title'     => 'Adicionar uma tag a :name',
        ],
        'title'     => 'Filhos da tag :name',
    ],
    'create'        => [
        'success'   => 'Tag \':name\' criada.',
        'title'     => 'Nova tag',
    ],
    'destroy'       => [
        'success'   => 'Tag \':name\' removida',
    ],
    'edit'          => [
        'success'   => 'Tag \':name\' atualizada',
        'title'     => 'Editar tag :name',
    ],
    'fields'        => [
        'children'  => 'Filhos',
        'name'      => 'Nome',
        'tag'       => 'Tag Principal',
        'tags'      => 'Subtags',
        'type'      => 'Tipo',
    ],
    'helpers'       => [
        'nested_parent' => 'Mostrando as tags de :parent.',
        'nested_without'=> 'Mostrando todas as tags que não tem uma tag-pai. Clique em uma linha para ver as tags-filhos.',
    ],
    'hints'         => [
        'children'  => 'Esta lista contém todas entidades diretamente relacionadas a esta tag e todas tags aninhadas nela.',
        'tag'       => 'Exibidas abaixo estão todas as tags diretamente relacionadas a ela.',
    ],
    'index'         => [
        'actions'   => [
            'explore_view'  => 'Visão Aninhada',
        ],
        'add'       => 'Nova tag',
        'header'    => 'Tags em :name',
        'title'     => 'Tags',
    ],
    'new_tag'       => 'Nova tag',
    'placeholders'  => [
        'name'  => 'Nome da tag',
        'tag'   => 'Escolha a Tag Principal',
        'type'  => 'Tradições, Guerras, História, Religião, Vexilologia',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Filhos',
            'tags'      => 'Tags',
        ],
        'title' => 'Tag :name',
    ],
    'tags'          => [
        'title' => 'Filhos da tag :name',
    ],
];
