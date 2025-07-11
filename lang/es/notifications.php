<?php

return [
    'apps'              => [
        'discord'   => [
            'invalid'   => 'Tu token de Discord ha expirado. Por favor, vuelve a sincronizar tu cuenta de Discord con Kanka.',
        ],
    ],
    'campaign'          => [
        'application'       => [
            'approved'              => 'Tu solicitud para la campaña :campaign ha sido aprobada.',
            'approved_message'      => 'Tu inscripción a la campaña :campaign ha sido aprobada. Mensaje proporcionado: :reason',
            'new'                   => 'Nueva solicitud para :campaign.',
            'rejected'              => 'Tu solicitud para la campaña :campaign ha sido rechazada. Motivo:',
            'rejected_no_message'   => 'Su inscripción a la campaña :campaign ha sido rechazada.',
        ],
        'asset_export'      => 'Está disponible una exportación de la campaña. El enlace estará disponible durante :time minutos.',
        'boost'             => [
            'add'           => ':user está mejorando la campaña :campaign.',
            'remove'        => ':user ya no está mejorando la campaña :campaign.',
            'superboost'    => ':user está supermejorando la campaña :campaign.',
        ],
        'deleted'           => 'Se ha eliminado la campaña :campaign.',
        'export'            => 'Ya se ha exportado tu campaña. El enlace estará disponible durante :time minutos.',
        'export_error'      => 'Ha ocurrido un error mientras se exportaba tu campaña. Por favor, contáctanos si el error persiste.',
        'hidden'            => 'La campaña :campaign está ahora oculta de la página de campañas públicas.',
        'import'            => [
            'failed'    => 'La importación de la campaña :campaign ha fallado.',
            'success'   => 'La campaña :campaign ha terminado de importarse.',
        ],
        'join'              => ':user se ha unido a la campaña :campaign.',
        'leave'             => ':user ha abandonado la campaña :campaign.',
        'new_owner'         => 'Has sido designado administrador de :campaign.',
        'plugin'            => [
            'deleted'   => 'El plugin :plugin se ha eliminado del marketplace y de tu campaña :campaign.',
        ],
        'premium'           => [
            'add'       => 'Se han desbloqueado funciones premium para la campaña :campaign por :user.',
            'remove'    => ':user ya no desbloquea funciones premium para la campaña :campaign.',
        ],
        'removed-image'     => 'La imagen o cabecera de :entity se ha eliminado debido a un reclamo de derechos de autor.',
        'role'              => [
            'add'       => 'Te han asignado el rol :role en la campaña :campaign.',
            'remove'    => 'Has sido eliminado del rol :role en la campaña :campaign.',
        ],
        'troubleshooting'   => [
            'joined'    => ':user, miembro del equipo de Kanka, se ha unido a la campaña :campaign.',
        ],
    ],
    'clear'             => [
        'action'    => 'Borrar todas',
        'success'   => 'Se han eliminado las notificaciones.',
        'title'     => 'Borrar notificaciones',
    ],
    'features'          => [
        'approved'  => 'Tu idea :feature ha sido aprobada.',
        'finished'  => '¡Tu idea :feature ya está disponible en Kanka!',
        'rejected'  => 'Tu idea :feature ha sido rechazada, motivo: :reason.',
    ],
    'header'            => 'Tienes :count notificaciones',
    'index'             => [
        'title' => 'Notificaciones',
    ],
    'map'               => [
        'chunked'   => 'El mapa :name ha terminado de fragmentarse y ya puede utilizarse.',
    ],
    'no_notifications'  => 'No tienes ninguna notificación.',
    'plugins'           => [
        'comments'  => [
            'new_comment'   => ':user ha dejado un nuevo comentario en el plugin :plugin.',
            'new_reply'     => ':user ha respondido a tu comentario en :plugin.',
        ],
    ],
    'subscriptions'     => [
        'charge_fail'   => 'Ha habido un error procesando tu pago. Espera un momento mientras volvemos a intentarlo. Si no se producen cambios, contacta con nosotros.',
        'deleted'       => 'Tu suscripción a Kanka se ha cancelado tras demasiados intentos fallidos de hacer el cobro en tu tarjeta. Dirígete a la configuración de tu suscripción e intenta actualizar tus datos de pago.',
        'ended'         => 'Tu suscripción a Kanka ha finalizado. Se han eliminado tus mejoras de campaña y tus roles de Discord. ¡Esperamos volver a verte pronto!',
        'failed'        => 'Tu suscripción a Kanka se ha cancelado tras demasiados intentos de cargar el cobro en tu tarjeta. Dirígete a los ajustes de suscripción e intenta actualizar tus detalles de pago.',
        'started'       => 'Tu suscripción a Kanka ha empezado.',
    ],
    'unread'            => 'Nueva notificación',
];
