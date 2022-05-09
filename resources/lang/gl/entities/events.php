<?php

return [
    'fields'    => [
        'type'  => 'Tipo de evento',
    ],
    'helpers'   => [
        'characters'    => 'Establecer o tipo como data de nacemento ou de morte calculará a idade da personaxe automáticamente. :more.',
        'no_events'     => 'Esta interface mostra todos os calendarios aos que esta entidade está ligadamediante lembretes.',
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
