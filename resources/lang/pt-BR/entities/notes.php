<?php

return [
    'actions'       => [
        'add'   => 'Nova Nota de entidade',
    ],
    'create'        => [
        'description'   => 'Criar uma nova Nota de entidade',
        'success'       => 'Nota de entidade :name adicionada a :entity',
        'title'         => 'Nova nota de entidade de :name',
    ],
    'destroy'       => [
        'success'   => 'Nota de entidade :name de :entity removida',
    ],
    'edit'          => [
        'description'   => 'Atualize uma Nota existente',
        'success'       => 'Nota de entidade :name de :entity atualizada',
        'title'         => 'Atualizar Nota de :name',
    ],
    'fields'        => [
        'creator'   => 'Criador',
        'entry'     => 'Entrada',
        'name'      => 'Nome',
    ],
    'hint'          => 'As informações que não se enquadram nos campos padrão de uma entidade ou que devem ser mantidas em sigilo podem ser adicionadas como notas da entidade.',
    'index'         => [
        'title' => 'Notas de :name',
    ],
    'placeholders'  => [
        'name'  => 'Nome da Nota, observação ou comentário',
    ],
    'show'          => [
        'title' => 'Nota :name de :entity',
    ],
];
