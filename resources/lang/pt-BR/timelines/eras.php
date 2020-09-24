<?php

return [
    'actions'       => [
        'add'   => 'Adicionar nova era',
    ],
    'create'        => [
        'success'   => 'Era :name criada.',
        'title'     => 'Nova era',
    ],
    'delete'        => [
        'success'   => 'Era :name deletada.',
    ],
    'edit'          => [
        'success'   => 'Era :name atualizada.',
        'title'     => 'Editar era :name',
    ],
    'fields'        => [
        'abbreviation'  => 'Abreviação',
        'end_year'      => 'Ano inicial',
        'start_year'    => 'Ano final',
    ],
    'helpers'       => [
        'eras'      => 'Uma linha do tempo precisa ser criada antes que eras possam ser adicionadas a ela.',
        'primary'   => 'Separe sua linha do tempo em eras. Uma linha do tempo precisa de pelo menos uma era para funcionar corretamente.',
    ],
    'placeholders'  => [
        'abbreviation'  => 'a.C., d.C.',
        'end_year'      => 'Ano na qual a era termina. Deixe em branco se esta for a era atual.',
        'name'          => 'Era Moderna, Idade do Bronze, Guerras Galácticas',
        'start_year'    => 'Ano na qual a era começa. Deixe em branco se esta for a primeira era.',
    ],
    'reorder'       => [
        'success'   => 'Elementos da era :era reorganizados.',
    ],
];
