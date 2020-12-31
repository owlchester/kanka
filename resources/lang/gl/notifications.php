<?php

return [
    'campaign'          => [
        'boost'         => [
            'add'           => 'A campaña ":campaign" está potenciada por :user.',
            'remove'        => ':user xa non está potenciando a campaña ":campaign".',
            'superboost'    => 'A campaña ":capaign" está superpotenciada por :user.',
        ],
        'export'        => 'A exportación da campaña está dispoñíbel. Déscargaa facendo clic <a href=":link">aquí</a>. A ligazón estará dispoñíbel durante :time minutos.',
        'export_error'  => 'Ocorreu un erro mentres se exportaba a túa campaña. Por favor, contáctanos se o problema persiste.',
        'join'          => ':user uníuse á campaña ":campaign".',
        'leave'         => ':user abandonou a campaña ":campaign".',
        'role'          => [
            'add'       => 'Asignóuseche o rol ":role" na campaña "_campaign".',
            'remove'    => 'Retiróuseche o rol ":role" na campaña ":campaign".',
        ],
    ],
    'header'            => 'Tes :count notificacións',
    'index'             => [
        'description'   => 'As túas notificacións máis recentes.',
        'title'         => 'Notificacións',
    ],
    'no_notifications'  => 'Non tes notificacións.',
    'permissions'       => [
        'body'  => 'Ei, queremos informarte de que cambiamos completamente o sistema de permisos en cada campaña!</p><p>As campañas agora poden ter roles, e cada rol ter permisos para acceder, editar, ou eliminar entidades. Cada entidade tamén pode ser axustada con permisos individuais específicos, o cal quere dicir que Uxía e Roi poden editar as súas propias personaxes!</p><p>O único malo é que as campañas con moitas persoas integrantes terán que configurar os seus novos permisos. Se eres parte da Administración dunha campaña, podes facelo na páxina de administración da campaña. Se eres integrante dunha campaña, non verás nada ata que a administración desa campaña configure correctamente os permisos.',
        'title' => 'Cambios nos permisos',
    ],
    'subscriptions'     => [
        'charge_fail'   => 'Ocorreu un erro mentres se procesaba o teu pago. Por favor, espera un momento mentres o intentamos de novo. Se non cambia nada, contacta connosco.',
        'deleted'       => 'A túa subscripción a Kanka foi cancelada tras moitos intentos errados de cobrar a túa tarxeta. Por favor, vai á configuración da túa subscripción e intenta actualizar os teus detalles de pagamento.',
        'ended'         => 'A túa subscripción a Kanka terminou. As túas potenciacións de campaña e roles de Discord foron eliminados. Esperamos verte de novo!',
        'failed'        => 'Non foi posíbel procesar os teus detalles de pagamento. Por favor, actualízaos na túa configuración de Método de Pago.',
        'started'       => 'A túa subscripción a Kanka foi iniciada.',
    ],
];
