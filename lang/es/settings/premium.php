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
    'pitch'         => [
        'description'   => 'Hazte premium en las campañas y ayuda a desbloquear funciones increíbles para todos los participantes.',
        'more'          => 'Consulta la lista completa de ventajas en nuestra página :premium.',
        'title'         => 'Las campañas premium obtienen',
    ],
    'ready'         => [
        'available'         => 'Sus campañas premium disponibles.',
        'pricing'           => 'Todos nuestros niveles de suscripción incluyen al menos una campaña premium y comienzan desde :amount al mes.',
        'pricing-amount'    => ':currency:amount',
        'title'             => 'Vuélvete premium',
    ],
    'remove'        => [
        'confirm'   => 'Sí, estoy seguro',
        'cooldown'  => 'Las características premium de :campaign pueden ser removidas después de :date.',
        'success'   => 'Se han removido las características premium de la campaña :campaign. Ahora puedes desbloquear funciones premium en otra campaña.',
        'title'     => 'Removiendo características premium',
        'warning'   => '¿Estás seguro de que quieres eliminar las características premium de :campaign? Esto te permitirá desbloquear otra campaña y ocultará todo el contenido y las características premium relacionadas con las características hasta que se vuelva a activar el estado premium de la campaña.',
    ],
];
