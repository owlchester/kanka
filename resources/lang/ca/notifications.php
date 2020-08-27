<?php

return [
    'campaign'          => [
        'boost'         => [
            'add'       => 'Tu campaña está siendo mejorada por :user.',
            'remove'    => ':user ya no está mejorando la campaña :campaign.',
        ],
        'export'        => 'Ya se ha exportado tu campaña. Puedes descargarla haciendo click en <a href=":link">aquí</a>. El enlace estará disponible durante 30 minutos.',
        'export_error'  => 'Ha ocurrido un error mientras se exportaba tu campaña. Por favor, contáctanos si el error persiste.',
        'join'          => ':user se ha unido a la campaña :campaign.',
        'leave'         => ':user ha abandonado la campaña :campaign.',
        'role'          => [
            'add'       => 'Te han asignado el rol :role en la campaña :campaign.',
            'remove'    => 'Has sido eliminado del rol :role en la campaña :campaign.',
        ],
    ],
    'header'            => 'Tienes :count notificaciones',
    'index'             => [
        'description'   => 'Tus notificaciones recientes.',
        'title'         => 'Notificaciones',
    ],
    'no_notifications'  => 'No tienes ninguna notificación.',
    'permissions'       => [
        'body'  => '¡Hola, queremos que sepas que hemos cambiado completamente el sistema de permisos en cada campaña!</p><p>Ahora las campañas pueden tener roles, y cada rol puede tener permisos de acceso, edición o eliminación de entidades. ¡Además, cada entidad puede ser afinada con permisos específicos de usuario, así que Rebeca y Alfredo ahora pueden editar sus propios personajes!</p><p>La única desventaja es que las campañas con varios usuarios tendrán que configurar sus nuevos permisos. Si eres el Administrador de una campaña, puedes hacerlo en la página de administración de la campaña. Si formas parte de una campaña, no verás nada hasta que el propietario lo haya configurado.',
        'title' => 'Cambios en los permisos',
    ],
    'subscriptions'     => [
        'charge_fail'   => 'Ha habido un error procesando tu pago. Por favor, espera un momento mientras volvemos a intentarlo. Si no se producen cambios, contacta con nosotros.',
        'ended'         => 'Tu suscripción a Kanka ha finalizado. Se han eliminado tus mejoras de campaña y tus roles de Discord. ¡Esperamos volver a verte pronto!',
        'failed'        => 'Tu suscripción a Kanka se ha cancelado tras demasiados intentos de cargar el cobro en tu tarjeta. Por favor, dirígete a los ajustes de suscripción e intenta actualizar tus detalles de pago.',
        'started'       => 'Tu suscripción a Kanka ha empezado.',
    ],
];
