<?php

return [
    'actions'       => [
        'add'   => 'Engadir unha nova era',
    ],
    'create'        => [
        'success'   => 'Era ":name" creada.',
        'title'     => 'Nova era',
    ],
    'delete'        => [
        'success'   => 'Era ":name" eliminada.',
    ],
    'edit'          => [
        'success'   => 'Era ":name" actualizada.',
        'title'     => 'Editar era ":name"',
    ],
    'fields'        => [
        'abbreviation'  => 'Abreviatura',
        'end_year'      => 'Ano final',
        'start_year'    => 'Ano inicial',
    ],
    'helpers'       => [
        'eras'      => 'A liña temporal ten que ser creada antes de poder engadirlle eras.',
        'primary'   => 'Separa a túa liña temporal en eras. Unha liña temporal precisa polo menos unha era para funcionar adecuadamente.',
    ],
    'placeholders'  => [
        'abbreviation'  => 'DC, AC, AD...',
        'end_year'      => 'Ano no que finaliza a era. Déixao en branco se esta é a era actual.',
        'name'          => 'Era moderna, Idade de bronce, Guerras galácticas...',
        'start_year'    => 'Ano no que comeza a era. Déixao en branco se esta é a primeira era.',
    ],
    'reorder'       => [
        'success'   => 'Elementos da era ":era" reordenados.',
    ],
];
