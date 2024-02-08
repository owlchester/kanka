<?php

return [
    'actions'       => [
        'remove'    => 'Remover premium',
        'unlock'    => 'Convertirse en Premium',
    ],
    'create'        => [
        'actions'   => [
            'confirm'   => '¡Convertirse en premium!',
        ],
        'confirm'   => '¡Qué emocionante! Estás a punto de desbloquear funciones premium para :campaign. Esto utilizará una de tus campañas premium disponibles.',
        'duration'  => 'Las campañas Premium permanecen así hasta que lo retires manualmente, o cuando finalice tu suscripción.',
        'pitch'     => 'Conviertete en suscriptor para desbloquear campañas premium.',
        'success'   => 'La campaña :campaign ahora es premium. ¡Disfruta de todas las nuevas e increíbles funciones!',
    ],
    'exceptions'    => [
        'already'       => 'Ya se han desbloqueado las funciones Premium para esta campaña.',
        'out-of-stock'  => 'No tienes suficientes campañas premium disponibles para activar esta campaña. Elimina el estado premium de otra campaña o :upgrade.',
    ],
];
