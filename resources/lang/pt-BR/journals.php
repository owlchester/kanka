<?php

return [
    'create'        => [
        'success'   => 'Jornal criado.',
        'title'     => 'Criar novo jornal',
    ],
    'destroy'       => [
        'success'   => 'Jornal removido',
    ],
    'edit'          => [
        'success'   => 'Jornal atualizado',
        'title'     => 'Editar Jornal :name',
    ],
    'fields'        => [
        'author'    => 'Autor',
        'date'      => 'Data',
        'image'     => 'Imagem',
        'journal'   => 'Jornal Principal',
        'journals'  => 'Jornais secundários',
        'name'      => 'Nome',
        'type'      => 'Tipo',
    ],
    'helpers'       => [
        'journals'      => 'Mostrar todos ou somente os jornais secundários deste Jornal',
        'nested_parent' => 'Mostrando os jornais de :parent.',
        'nested_without'=> 'Mostrando todos os jornais que não tem um jornal-pai. Clique em uma linha para ver os jornais-filhos.',
    ],
    'index'         => [
        'title' => 'Jornais',
    ],
    'journals'      => [
        'title' => 'Jornais secundários do Jornal :name',
    ],
    'placeholders'  => [
        'author'    => 'Quem escreveu o jornal',
        'date'      => 'Data do jornal',
        'journal'   => 'Escolha um Jornal Principal',
        'name'      => 'Nome do jornal',
        'type'      => 'Sessão, One Shot, Rascunho',
    ],
    'show'          => [
        'tabs'  => [
            'journals'  => 'Jornais',
        ],
    ],
];
