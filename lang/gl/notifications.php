<?php

return [
    'campaign'          => [
        'application'           => [
            'approved'              => 'A túa solicitude de inscrición na campaña ":campaign" foi aprobada.',
            'approved_message'      => 'A túa solicitude de inscrición na campaña ":campaign" foi aprobada. Mensaxe proporcionada: :reason',
            'new'                   => 'Nova solicitude de inscrición en ":campaign".',
            'rejected'              => 'A túa solicitude de inscrición na campaña ":campaign" foi rexeitada. Motivo: :reason',
            'rejected_no_message'   => 'A túa solicitude de inscrición na campaña ":campaign" foi rexeitada.',
        ],
        'asset_export'          => 'Hai unha exportación de campaña dispoñible, A ligazón estará activa durante :time minutos.',
        'asset_export_error'    => 'Ocorreu un erro durante a exportación dos recursos da campaña. Isto pode pasar en campañas moi grandes.',
        'boost'                 => [
            'add'           => 'A campaña ":campaign" está potenciada por :user.',
            'remove'        => ':user xa non está potenciando a campaña ":campaign".',
            'superboost'    => 'A campaña ":campaign" está agora sendo superpotenciada por :user.',
        ],
        'deleted'               => 'A campaña ":campaign" foi eliminada.',
        'export'                => 'A exportación da campaña está dispoñible. A ligazón estará dispoñible durante :time minutos.',
        'export_error'          => 'Ocorreu un erro mentres se exportaba a túa campaña. Por favor, contacta connosco se o problema persiste.',
        'hidden'                => 'A campaña ":campaign" está agora oculta. Non aparecerá na páxina de campañas públicas.',
        'join'                  => ':user uníuse á campaña ":campaign".',
        'leave'                 => ':user abandonou a campaña ":campaign".',
        'plugin'                => [
            'deleted'   => 'A extensión ":plugin" foi eliminado do mercado e da túa campaña ":campaign".',
        ],
        'role'                  => [
            'add'       => 'Asignóuseche o rol ":role" na campaña ":campaign".',
            'remove'    => 'Retiróuseche o rol ":role" na campaña ":campaign".',
        ],
        'shown'                 => 'A campaña ":campaign" é agora visible na páxina de campañas públicas.',
        'troubleshooting'       => [
            'joined'    => ':user (integrante do equipo de Kanka) uníuse á campaña ":campaign".',
        ],
    ],
    'clear'             => [
        'action'    => 'Limpar todas',
        'success'   => 'Notificacións eliminadas.',
        'title'     => 'Limpar notificacións',
    ],
    'header'            => 'Tes :count notificacións',
    'index'             => [
        'title' => 'Notificacións',
    ],
    'map'               => [
        'chunked'   => 'O mapa ":name" terminou de ser fragmentado e xa pode ser usado.',
    ],
    'no_notifications'  => 'Non tes notificacións.',
    'subscriptions'     => [
        'charge_fail'   => 'Ocorreu un erro mentres se procesaba o teu pagamento. Por favor, espera un momento mentres o intentamos de novo. Se non cambia nada, contacta connosco.',
        'deleted'       => 'A túa subscripción a Kanka foi cancelada tras moitos intentos errados de cobrar a túa tarxeta. Por favor, vai á configuración da túa subscripción e intenta actualizar os teus detalles de pagamento.',
        'ended'         => 'A túa subscripción a Kanka terminou. As túas potenciacións de campaña e roles de Discord foron eliminados. Esperamos verte de novo!',
        'failed'        => 'Non foi posible procesar os teus detalles de pagamento. Por favor, actualízaos na túa configuración de Método de Pagamento.',
        'started'       => 'A túa subscripción a Kanka foi iniciada.',
    ],
    'unread'            => 'Nova notificación',
];
