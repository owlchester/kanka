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
        'fail'      => 'Falha ao transferir entidades de :tag para :newTag',
        'success'   => 'Entidades transferidas com sucesso de :tag para :newTag',
        'transfer'  => 'Transferir',
    ],
];
