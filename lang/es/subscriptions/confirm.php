<?php

return [
    'actions'   => [
        'pay'       => 'Paga :currency:amount ahora',
        'subscribe' => 'Suscribirse por :currency:amount',
    ],
    'helpers'   => [
        'auto-renew'    => [
            'monthly'   => 'Tu suscripción se renueva automáticamente cada mes. La próxima fecha de facturación es :date.',
            'yearly'    => 'Tu suscripción se renueva automáticamente cada 12 meses. La próxima fecha de facturación es :date.',
        ],
        'refund'        => 'Ofrecemos una política de reembolso sin preguntas durante 14 días en todas las suscripciones anuales. Simplemente envíanos un correo a :email para iniciar el proceso de reembolso.',
        'tiny'          => 'Gracias por apoyar a un pequeño equipo de apasionados creadores de mundos.',
    ],
    'title'     => 'Suscripción de :name',
];
