<?php

return [
    'actions'   => [
        'pay'       => 'Paga :currency:amount ahora',
        'paypal'    => 'Paga :currency:amount con PayPal',
    ],
    'helpers'   => [
        'auto-renew'    => [
            'monthly'   => 'Tu suscripción se renueva automáticamente cada mes. La próxima fecha de facturación es :date.',
            'none'      => 'Pagar con PayPal es un pago único y no se renueva automáticamente. Puedes volver a suscribirte cuando tu suscripción termine después de :date.',
            'yearly'    => 'Tu suscripción se renueva automáticamente cada 12 meses. La próxima fecha de facturación es :date.',
        ],
        'paypal'        => 'Serás redirigido a PayPal para completar esta transacción.',
        'refund'        => 'Ofrecemos una política de reembolso sin preguntas durante 14 días en todas las suscripciones anuales. Simplemente envíanos un correo a :email para iniciar el proceso de reembolso.',
    ],
    'title'     => 'Suscripción de :name',
];
