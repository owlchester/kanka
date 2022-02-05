<?php

return [
    'campaign'          => [
        'application'           => [
            'approved'  => 'Tu solicitud para la campaña :campaign ha sido aprobada.',
            'new'       => 'Nueva solicitud para :campaign.',
            'rejected'  => 'Tu solicitud para la campaña :campaign ha sido rechazada. Motivo:',
        ],
        'asset_export'          => 'Está disponible una exportación de la campaña. El enlace estará disponible durante :time minutos.',
        'asset_export_error'    => 'Ha ocurrido un error durante la exportación de los assets de la campaña. Esto puede ocurrir en las campañas muy grandes.',
        'boost'                 => [
            'add'           => ':user está mejorando la campaña :campaign.',
            'remove'        => ':user ya no está mejorando la campaña :campaign.',
            'superboost'    => ':user está supermejorando la campaña :campaign.',
        ],
        'deleted'               => 'Se ha eliminado la campaña :campaign.',
        'export'                => 'Ya se ha exportado tu campaña. El enlace estará disponible durante :time minutos.',
        'export_error'          => 'Ha ocurrido un error mientras se exportaba tu campaña. Por favor, contáctanos si el error persiste.',
        'join'                  => ':user se ha unido a la campaña :campaign.',
        'leave'                 => ':user ha abandonado la campaña :campaign.',
        'plugin'                => [
            'deleted'   => 'El plugin :plugin se ha eliminado del marketplace y de tu campaña :campaign.',
        ],
        'role'                  => [
            'add'       => 'Te han asignado el rol :role en la campaña :campaign.',
            'remove'    => 'Has sido eliminado del rol :role en la campaña :campaign.',
        ],
        'troubleshooting'       => [
            'joined'    => ':user, miembro del equipo de Kanka, se ha unido a la campaña :campaign.',
        ],
    ],
    'clear'             => [
        'action'    => 'Borrar todas',
        'confirm'   => '¿Seguro que quieres eliminar todas las notificaciones? Esta acción no se puede deshacer.',
        'success'   => 'Se han eliminado las notificaciones.',
    ],
    'header'            => 'Tienes :count notificaciones',
    'index'             => [
        'title' => 'Notificaciones',
    ],
    'no_notifications'  => 'No tienes ninguna notificación.',
    'permissions'       => [],
    'subscriptions'     => [
        'charge_fail'   => 'Ha habido un error procesando tu pago. Espera un momento mientras volvemos a intentarlo. Si no se producen cambios, contacta con nosotros.',
        'deleted'       => 'Tu suscripción a Kanka se ha cancelado tras demasiados intentos fallidos de hacer el cobro en tu tarjeta. Dirígete a la configuración de tu suscripción e intenta actualizar tus datos de pago.',
        'ended'         => 'Tu suscripción a Kanka ha finalizado. Se han eliminado tus mejoras de campaña y tus roles de Discord. ¡Esperamos volver a verte pronto!',
        'failed'        => 'Tu suscripción a Kanka se ha cancelado tras demasiados intentos de cargar el cobro en tu tarjeta. Dirígete a los ajustes de suscripción e intenta actualizar tus detalles de pago.',
        'started'       => 'Tu suscripción a Kanka ha empezado.',
    ],
    'unread'            => 'Nueva notificación',
];
