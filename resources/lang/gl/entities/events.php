<?php

return [
    'fields'    => [
        'type'  => 'Tipo de evento',
    ],
    'helpers'   => [
        'characters'    => 'Establecer o tipo como data de nacemento ou de morte calculará a idade da personaxe automáticamente. :more.',
    ],
    'show'      => [
        'actions'   => [
            'add'   => 'Engadir lembrete',
        ],
        'title'     => 'Lembretes de ":name"',
    ],
    'types'     => [
        'birth'     => 'Nacemento',
        'death'     => 'Morte',
        'primary'   => 'Primario',
    ],
];
