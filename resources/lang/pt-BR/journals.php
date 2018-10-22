<?php

return [
    'create'        => [
        'description'   => 'Criar um novo jornal',
        'success'       => 'Jornal criado.',
        'title'         => 'Criar novo jornal',
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
        'name'      => 'Nome',
        'relation'  => 'Relação',
        'type'      => 'Tipo',
    ],
    'index'         => [
        'add'           => 'Novo Jornal',
        'description'   => 'Gerencie os jornais de :name.',
        'header'        => 'Jornais de :name',
        'title'         => 'Jornais',
    ],
    'placeholders'  => [
        'author'    => 'Quem escreveu o jornal',
        'date'      => 'Data do jornal',
        'name'      => 'Nome do jornal',
        'type'      => 'Sessão, One Shot, Rascunho',
    ],
    'show'          => [
        'description'   => 'Uma visão detalhada de um jornal',
        'title'         => 'Jornal :name',
    ],
];
