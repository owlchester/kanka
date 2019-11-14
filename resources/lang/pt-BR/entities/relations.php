<?php

return [
    'create'        => [
        'success'   => 'Relação adicionada para :name.',
        'title'     => 'Criar relações',
    ],
    'destroy'       => [
        'success'   => 'Relação de :name removida.',
    ],
    'fields'        => [
        'relation'  => 'Relação',
        'target'    => 'Alvo',
        'two_way'   => 'Criar relação mútua',
    ],
    'hints'         => [
        'two_way'   => 'Se você selecionar para criar relação mútua, a mesma relação será criada no alvo. Entretanto, se você editar uma, a outra não será atualizada.',
    ],
    'placeholders'  => [
        'relation'  => 'Natureza da relação',
        'target'    => 'Escolha uma entidade',
    ],
    'update'        => [
        'success'   => 'Relação de :name atualizada.',
        'title'     => 'Atualizar relações',
    ],
];
