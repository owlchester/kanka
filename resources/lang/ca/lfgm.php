<?php

return [
    'sync'  => [
        'actions'   => [
            'sync'  => 'Sincronizar',
        ],
        'errors'    => [
            'invalid_uuid'  => 'Id de campaña LFGM inválida. Por favor, vuelve a intentarlo.',
        ],
        'helper'    => 'Selecciona una campaña para sincronizar tus eventos con :lfgm. Así, se fijará una Nota al tablero de campaña con tus próximos eventos.',
        'successes' => [
            'sync'  => 'Calendario LFGM sincronizado.',
        ],
        'title'     => 'Sincronizar campaña con LookingForGM.com',
    ],
];
