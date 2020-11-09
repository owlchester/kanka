<?php

return [
    'sync'  => [
        'actions'   => [
            'sync'  => 'Sincronizar',
        ],
        'errors'    => [
            'invalid_uuid'  => 'ID de campaña LFGM inválido. Por favor volva intentalo.',
        ],
        'helper'    => 'Selecciona unha campaña para sincronizar os teus próximos eventos de :lfgm. Isto engadirá unha nota cos teus próximos eventos e a fixará no taboleiro da campaña.',
        'successes' => [
            'sync'  => 'Calendario LFGM sincronizado.',
        ],
        'title'     => 'Subcronización de campaña con LookingForGM.com',
    ],
];
