<?php

return [
    'characters'    => [],
    'create'        => [
        'title' => 'Nova Raça',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'members'   => 'Membros',
    ],
    'helpers'       => [],
    'hints'         => [
        'is_extinct'    => 'Essa raça está extinta.',
    ],
    'index'         => [],
    'members'       => [
        'create'    => [
            'helper'    => 'Adicionar um ou vários personagens à :name',
            'submit'    => 'Adicionar membros',
            'success'   => '{0} Nenhum membro foi adicionado.|{1} 1 membro foi adicionado.|[2,*] :count membros foram adicionados.',
            'title'     => 'Novos Membros',
        ],
    ],
    'placeholders'  => [
        'type'  => 'Humano, Fada, Ciborgue',
    ],
    'races'         => [],
    'show'          => [],
];
