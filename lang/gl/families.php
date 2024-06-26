<?php

return [
    'create'        => [
        'title' => 'Nova familia',
    ],
    'destroy'       => [],
    'edit'          => [],
    'families'      => [],
    'fields'        => [
        'members'   => 'Integrantes',
    ],
    'helpers'       => [],
    'hints'         => [
        'members'   => 'As persoas integrantes dunha familia móstranse aquí. Unha personaxe pode ser engadida a unha familia editando esa personaxe e usando o campo "Familia".',
    ],
    'index'         => [],
    'members'       => [
        'helpers'   => [
            'all_members'       => 'A seguinte lista contén todas as personaxes que están nesta familia ou nalgunha das súas subfamilias.',
            'direct_members'    => 'Algunhas familias teñen integrantes que a lideraron ou a fixeron famosa. Aquí móstranse as personaxes que están directamente nesta familia.',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Nome da familia',
        'type'  => 'Real, nobre, extinta...',
    ],
    'show'          => [
        'tabs'  => [
            'members'   => 'Integrantes',
        ],
    ],
];
