<?php

return [
    'campaign'          => [
        'application'   => [
            'approved'  => 'A túa solicitude de inscrición na campaña ":campaign" foi aprobada.',
            'new'       => 'Nova solicitude de inscrición en ":campaign".',
            'rejected'  => 'A túa solicitude de inscrición na campaña ":campaign" foi rexeitada. Motivo: :reason',
        ],
        'asset_export'  => 'Hai unha exportación de campaña dispoñíbel, A ligazón estará activa durante :time minutos.',
        'boost'         => [
            'add'           => 'A campaña ":campaign" está potenciada por :user.',
            'remove'        => ':user xa non está potenciando a campaña ":campaign".',
            'superboost'    => 'A campaña ":capaign" está superpotenciada por :user.',
        ],
        'export'        => 'A exportación da campaña está dispoñíbel. A ligazón estará dispoñíbel durante :time minutos.',
        'export_error'  => 'Ocorreu un erro mentres se exportaba a túa campaña. Por favor, contacta connosco se o problema persiste.',
        'join'          => ':user uníuse á campaña ":campaign".',
        'leave'         => ':user abandonou a campaña ":campaign".',
        'plugin'        => [
            'deleted'   => 'A extensión ":plugin" foi eliminado do mercado e da túa campaña ":campaign".',
        ],
        'role'          => [
            'add'       => 'Asignóuseche o rol ":role" na campaña ":campaign".',
            'remove'    => 'Retiróuseche o rol ":role" na campaña ":campaign".',
        ],
    ],
    'header'            => 'Tes :count notificacións',
    'index'             => [
        'description'   => 'As túas notificacións máis recentes.',
        'title'         => 'Notificacións',
    ],
    'no_notifications'  => 'Non tes notificacións.',
    'permissions'       => [],
    'subscriptions'     => [
        'charge_fail'   => 'Ocorreu un erro mentres se procesaba o teu pagamento. Por favor, espera un momento mentres o intentamos de novo. Se non cambia nada, contacta connosco.',
        'deleted'       => 'A túa subscripción a Kanka foi cancelada tras moitos intentos errados de cobrar a túa tarxeta. Por favor, vai á configuración da túa subscripción e intenta actualizar os teus detalles de pagamento.',
        'ended'         => 'A túa subscripción a Kanka terminou. As túas potenciacións de campaña e roles de Discord foron eliminados. Esperamos verte de novo!',
        'failed'        => 'Non foi posíbel procesar os teus detalles de pagamento. Por favor, actualízaos na túa configuración de Método de Pagamento.',
        'started'       => 'A túa subscripción a Kanka foi iniciada.',
    ],
];
