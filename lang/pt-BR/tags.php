<?php

return [
    'children'      => [
        'actions'   => [
            'add'   => 'Add à tag',
        ],
        'create'    => [
            'success'   => 'Adicionado a tag :name para a entidade.',
            'title'     => 'Adicionar uma tag a :name',
        ],
        'title'     => 'Tag Secundária de :name',
    ],
    'create'        => [
        'title' => 'Nova tag',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'children'          => 'Filhos',
        'is_auto_applied'   => 'Aplicar automaticamente a novas entidades',
        'is_hidden'         => 'Ocultar do cabeçalho e da dica de contexto',
        'tag'               => 'Tag Primária',
        'tags'              => 'Subtags',
    ],
    'helpers'       => [
        'nested_without'    => 'Exibindo todas as tags que não tem uma tag primária. Clique em uma linha para ver as tags secundárias.',
        'no_children'       => 'No momento não há entidades marcadas com esta tag.',
    ],
    'hints'         => [
        'children'          => 'Esta lista contém todas entidades diretamente relacionadas a esta tag ou às tags secundárias.',
        'is_auto_applied'   => 'Marque esta opção para aplicar automaticamente esta tag a entidades recém-criadas.',
        'is_hidden'         => 'Se marcada. esta tag não será exibida no cabeçalho ou dica de contexto de uma entidade.',
        'tag'               => 'Esta lista contém todas as tags secundárias desta tag ou de suas tags secundárias.',
    ],
    'index'         => [],
    'new_tag'       => 'Nova Tag',
    'placeholders'  => [
        'name'  => 'Nome da tag',
        'tag'   => 'Escolha uma tag primária',
        'type'  => 'Tradições, Guerras, História, Religião, Vexilologia',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Filhos',
            'tags'      => 'Tags',
        ],
    ],
    'tags'          => [
        'title' => 'Tag Secundária de :name',
    ],
];
