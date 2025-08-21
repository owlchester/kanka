<?php

return [
    'children'      => [
        'actions'   => [
            'add'           => 'Adicionar à tag',
            'add_entity'    => 'Adicionar à entidade',
        ],
        'create'    => [
            'attach_success'        => '{1} Adicionada :count entidade à tag :name.|[2,*] Adicionadas :count entidades à tag :name.',
            'attach_success_entity' => 'Tags atualizadas com sucesso para :name',
            'entity'                => 'Adicionar tags a :name',
            'helper'                => 'Marque uma ou várias entidades com :name',
            'title'                 => 'Entidades de tags',
        ],
    ],
    'create'        => [
        'title' => 'Nova Tag',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'children'          => 'Filhos',
        'is_auto_applied'   => 'Aplicar automaticamente a novas entidades',
        'is_hidden'         => 'Ocultar do cabeçalho e da dica de contexto',
    ],
    'helpers'       => [
        'no_children'   => 'No momento não há entidades marcadas com esta tag.',
        'no_posts'      => 'Atualmente não há nenhuma post marcado com esta tag.',
    ],
    'hints'         => [
        'children'          => 'Esta lista contém todas entidades diretamente relacionadas a esta tag ou às tags secundárias.',
        'is_auto_applied'   => 'Marque esta opção para aplicar automaticamente esta tag a entidades recém-criadas.',
        'is_hidden'         => 'Se marcada. esta tag não será exibida no cabeçalho ou dica de contexto de uma entidade.',
        'tag'               => 'Esta lista contém todas as tags secundárias desta tag ou de suas tags secundárias.',
    ],
    'index'         => [],
    'placeholders'  => [
        'type'  => 'Tradições, Guerras, História, Religião, Vexilologia',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Filhos',
        ],
    ],
    'tags'          => [],
    'transfer'      => [
        'entities'      => [
            'helper'    => 'Transferir entidades marcadas com :name para outra tag.',
            'title'     => 'Transferir entidades',
        ],
        'fail'          => 'Falha ao transferir entidades de :tag para :newTag',
        'fail_post'     => 'Falha ao transferir posts de :tag para :newTag',
        'posts'         => [
            'helper'    => 'Transfira posts marcados com :name para outra tag.',
            'title'     => 'Transferir posts',
        ],
        'success'       => 'Entidades transferidas com sucesso de :tag para :newTag',
        'success_post'  => 'Posts transferidos com sucesso de :tag para :newTag',
        'transfer'      => 'Transferir',
    ],
];
