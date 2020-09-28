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
        'attitude'  => 'Atitude',
        'is_star'   => 'Fixado',
        'relation'  => 'Relação',
        'target'    => 'Alvo',
        'two_way'   => 'Criar relação mútua',
    ],
    'helper'        => 'Estabeleça relações entre entidades com atitudes e visibilidade. Relações também podem ser fixadas no menu da entidade.',
    'hints'         => [
        'attitude'  => 'Este campo opcional pode ser usado para definir a ordem na qual as relações aparecem, em ordem decrescente.',
        'mirrored'  => [
            'text'  => 'Esta relação é espelhada com :link',
            'title' => 'Espelhada',
        ],
        'two_way'   => 'Se você selecionar para criar relação mútua, a mesma relação será criada no alvo. Entretanto, se você editar uma, a outra não será atualizada.',
    ],
    'placeholders'  => [
        'attitude'  => 'De -100 a100, com 100 sendo muito positiva',
        'relation'  => 'Natureza da relação',
        'target'    => 'Escolha uma entidade',
    ],
    'show'          => [
        'title' => 'Relações de :name',
    ],
    'teaser'        => 'Impulsione a campanha para ter acesso ao explorador de relações. Clique para saber mais sobre campanhas impulsionadas.',
    'types'         => [
        'family_member'         => 'Membro da família',
        'organisation_member'   => 'Membro da organização',
    ],
    'update'        => [
        'success'   => 'Relação de :name atualizada.',
        'title'     => 'Atualizar relações',
    ],
];
