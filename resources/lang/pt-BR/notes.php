<?php

return [
    'create'        => [
        'description'   => 'Criar uma nova nota',
        'success'       => 'Nota \':name\' criada.',
        'title'         => 'Criar uma nova nota',
    ],
    'destroy'       => [
        'success'   => 'Nota \':name\' removida.',
    ],
    'edit'          => [
        'success'   => 'Nota \':name\' atualizada.',
        'title'     => 'Editar Nota :name',
    ],
    'fields'        => [
        'description'   => 'Descrição',
        'image'         => 'Imagem',
        'is_pinned'     => 'Fixada',
        'name'          => 'Nome',
        'note'          => 'Nota Primária',
        'notes'         => 'Notas secundárias',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'nested'    => 'Mostrando primeiro notas que não tem uma Nota Primária. Clique em uma nota para explorar suas notas secundárias.',
    ],
    'hints'         => [
        'is_pinned' => 'Até 3 notas podem ser fixadas no dashboard',
    ],
    'index'         => [
        'add'           => 'Nova Nota',
        'description'   => 'Gerencie as notas de :name.',
        'header'        => 'Notas de :name',
        'title'         => 'Notas',
    ],
    'placeholders'  => [
        'name'  => 'Nome da nota',
        'note'  => 'Escolha uma nota Primária',
        'type'  => 'Religião, Raça, Sistema político',
    ],
    'show'          => [
        'description'   => 'Uma visão detalhada de uma nota',
        'tabs'          => [
            'description'   => 'Descrição',
        ],
        'title'         => 'Nota :name',
    ],
];
