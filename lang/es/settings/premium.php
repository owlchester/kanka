<?php

return [
    'actions'       => [
        'remove'    => 'Remover premium',
        'unlock'    => 'Convertirse en Premium',
    ],
    'create'        => [
        'actions'       => [
            'confirm'   => '¡Convertirse en premium!',
        ],
        'confirm'       => '¡Qué emocionante! Estás a punto de desbloquear funciones premium para :campaign. Esto utilizará una de tus campañas premium disponibles.',
        'duration'      => 'Las campañas Premium permanecen así hasta que lo retires manualmente, o cuando finalice tu suscripción.',
        'more'          => 'Además de temas personalizados, plugins, árboles genealógicos, categorías personalizadas y mucho más. Esto es solo una vista previa de todo lo que se desbloquea. Las campañas premium seguirán siéndolo hasta que elimines manualmente ese estado o finalice tu suscripción.',
        'no-stock'      => 'Vaya, parece que no tienes suficientes campañas premium disponibles para desbloquear esta campaña. Puedes quitar el estado premium de otra campaña o :upgrade.',
        'pitch'         => 'Una vista previa de lo que :name obtiene en cuanto te pasas a premium, y hay mucho más por descubrir.',
        'pitch_2026'    => 'Obtén roles, miembros, temas personalizados, plugins y más ilimitados para tus campañas.',
        'recap'         => [
            'control'   => [
                'description'   => 'Cambia la barra lateral, las categorías y mucho más',
                'title'         => 'Control total',
            ],
            'gallery'   => 'más espacio de almacenamiento para imágenes y recursos',
            'icons'     => 'iconos desbloqueados para este mundo',
            'instant'   => 'los miembros reciben mejoras al instante',
            'members'   => [
                'description'   => 'roles y miembros',
                'title'         => 'Ilimitado',
            ],
            'recovery'  => [
                'description'   => 'periodo para deshacer eliminaciones',
                'title'         => ':amount días',
            ],
            'size'      => 'límite de carga por miembro',
        ],
        'subtitle'      => 'Estás a punto de desbloquear premium para :name. Estas son algunas de las novedades que se aplicarán de inmediato.',
        'success'       => 'La campaña :campaign ahora es premium. ¡Disfruta de todas las nuevas e increíbles funciones!',
    ],
    'exceptions'    => [
        'already'       => 'Ya se han desbloqueado las funciones Premium para esta campaña.',
        'out-of-stock'  => 'No tienes suficientes campañas premium disponibles para activar esta campaña. Elimina el estado premium de otra campaña o :upgrade.',
    ],
    'pitch'         => [
        'description'   => 'Hazte premium en las campañas y ayuda a desbloquear funciones increíbles para todos los participantes.',
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
