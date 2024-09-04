<?php

return [
    'account'       => [
        '2fa'               => [
            'actions'               => [
                'disable'   => 'Deshabilitar la autenticación de dos factores',
                'finish'    => 'Finalizar la configuración e iniciar sesión',
            ],
            'activation_helper'     => 'Para terminar de configurar la autenticación de dos factores de tu cuenta, sigue estas instrucciones.',
            'disable'               => [
                'helper'    => 'Si quieres desactivar la autenticación de dos factores, haz clic en el botón de abajo. Ten en cuenta que esto dejará tu cuenta vulnerable a cualquiera que conozca tus datos de acceso.',
                'title'     => 'Deshabilitar la autenticación de dos factores',
            ],
            'enable_instructions'   => 'Para iniciar el proceso de activación, genera tu código QR de autenticación y escanéalo en la aplicación Google Authenticator (:ios, :android) u otra aplicación de autenticación similar.',
            'enabled'               => 'La autenticación de dos factores está actualmente activada en su cuenta.',
            'error_enable'          => 'Código inválido, inténtalo de nuevo',
            'fields'                => [
                'otp'       => 'Introduce la contraseña de un solo uso (OTP) proporcionada por la aplicación de autenticación.',
                'qrcode'    => 'Escanea el siguiente código QR con tu aplicación de autenticación para generar una contraseña de un solo uso (OTP).',
            ],
            'generate_qr'           => 'Generar código QR',
            'helper'                => 'La autenticación de dos factores (2FA) aumenta la seguridad del acceso al requerir dos métodos (también denominados factores) para verificar su identidad en cada inicio de sesión.',
            'learn_more'            => 'Más información sobre la autenticación de dos factores.',
            'social'                => 'La autenticación de dos factores de Kanka sólo está habilitada para los usuarios que inician sesión utilizando su correo electrónico y contraseña. Cambia tu método de inicio de sesión en la configuración de tu cuenta antes de poder activar esta opción.',
            'success_disable'       => 'Autenticación de dos factores desactivada correctamente.',
            'success_enable'        => 'La autenticación de dos factores se ha activado correctamente. Por favor, inicia sesión de nuevo para finalizar la configuración.',
            'success_key'           => 'Tu código QR seguro se ha generado correctamente. Por favor, completa la configuración para activar la autenticación de dos factores.',
            'title'                 => 'Autenticación de dos factores',
        ],
        'actions'           => [
            'social'            => 'Cambiar a inicio de sesión en Kanka',
            'update_email'      => 'Actualizar email',
            'update_password'   => 'Actualizar contraseña',
        ],
        'email'             => 'Cambiar email',
        'email_success'     => 'Email actualizado.',
        'password'          => 'Cambiar contraseña',
        'password_success'  => 'Contraseña actualizada.',
        'social'            => [
            'error'     => 'Ya estás utilizando el inicio de sesión de Kanka con esta cuenta.',
            'helper'    => 'Tu cuenta está vinculada con :provider. Puedes dejar de usarla y cambiar al inicio de sesión estándar de Kanka escribiendo una contraseña.',
            'success'   => 'Tu cuenta ahora usa el inicio de sesión de Kanka.',
            'title'     => 'De social a Kanka',
        ],
        'title'             => 'Cuenta',
    ],
    'api'           => [
        'helper'    => 'Bienvenido a las APIs de Kanka. Genera un Token de Acceso Personal para usar en tus llamadas a la API para obtener información sobre las campañas a las que perteneces.',
        'link'      => 'Leer la documentación de la API',
        'title'     => 'API',
    ],
    'apps'          => [
        'actions'   => [
            'connect'   => 'Conectar',
            'remove'    => 'Eliminar',
        ],
        'benefits'  => 'Kanka ofrece algunas integraciones con servicios de terceros. Hay más integraciones planeadas para el futuro.',
        'discord'   => [
            'confirm'   => '¿Estás seguro de que quieres desconectar tu cuenta de Discord? Esto eliminará todos los roles con los que hayas estado sincronizado.',
            'errors'    => [
                'add'   => 'Ha ocurrido un error tratando de vincular tu cuenta de Discord con Kanka. Por favor, inténtalo de nuevo.',
            ],
            'success'   => [
                'add'       => 'Se ha vinculado tu cuenta de Discord.',
                'remove'    => 'Se ha desvinculado tu cuenta de Discord.',
            ],
            'text'      => 'Accede a los roles de suscripción automáticamente.',
            'unlock'    => 'Desbloquear roles de Discord',
        ],
        'title'     => 'Integración de aplicaciones',
    ],
    'billing'       => [
        'placeholder'   => 'Si necesitas añadir información adicional de contacto o fiscal a tus recibos (dirección comercial, número de IVA, etc.), introdúcela a continuación y aparecerá en todos tus recibos.',
        'save'          => 'Guardar los datos de facturación',
        'title'         => 'Datos de facturación',
    ],
    'boost'         => [
        'exceptions'    => [
            'already_boosted'       => 'La campaña :name ya está mejorada.',
            'exhausted_boosts'      => 'Te has quedado sin mejoras. Elimina tu mejora de una campaña antes de dársela a otra.',
            'exhausted_superboosts' => 'Te has quedado sin mejoras. Necesitas 3 mejoras para supermejorar una campaña.',
        ],
    ],
    'countries'     => [
        'austria'       => 'Austria',
        'belgium'       => 'Bégica',
        'france'        => 'Francia',
        'germany'       => 'Alemania',
        'italy'         => 'Italia',
        'netherlands'   => 'Holanda',
        'spain'         => 'España',
    ],
    'invoices'      => [],
    'layout'        => [
        'title' => 'Diseño',
    ],
    'marketplace'   => [],
    'menu'          => [
        'account'               => 'Cuenta',
        'api'                   => 'API',
        'appearance'            => 'Apariencia',
        'apps'                  => 'Aplicaciones',
        'boosters'              => 'Potenciadores',
        'notifications'         => 'Notificaciones',
        'other'                 => 'Otros',
        'patreon'               => 'Patreon',
        'payment_options'       => 'Opciones de pago',
        'personal_settings'     => 'Ajustes personales',
        'premium'               => 'Campañas Premium',
        'profile'               => 'Perfil',
        'settings'              => 'Configuración',
        'subscription'          => 'Suscripción',
        'subscription_status'   => 'Estado de la suscripción',
    ],
    'patreon'       => [
        'deprecated'    => 'Funcionalidad obosleta. Si deseas apoyar a Kanka, puedes hacerlo mediante una :subscription. La vinculación con Patreon aún sigue activa para nuestros Patrons que vincularon sus cuentas antes de la mudanza de Patreon.',
        'pledge'        => 'Pledge :name',
        'remove'        => [
            'button'    => 'Desvincular mi cuenta de Patreon',
            'success'   => 'Tu cuenta de Patreon se ha desvinculado.',
            'text'      => 'Desvincular tu cuenta de Patreon de Kanka eliminará tus bonus, tu nombre en el salón de la fama, tus mejoras y otras funcionalidades vinculadas. Sin embargo, tu contenido mejorado no se perderá: si vuelves a suscribirte, volverás a tener acceso a esos datos, incluyendo la posibilidad de volver a mejorar dicha campaña.',
            'title'     => 'Desvincular mi cuenta de Patreon de Kanka',
        ],
        'title'         => 'Patreon',
    ],
    'profile'       => [
        'actions'   => [
            'update_profile'    => 'Actualizar perfil',
        ],
        'avatar'    => 'Foto de perfil',
        'success'   => 'Perfil actualizado.',
        'title'     => 'Perfil personal',
    ],
    'subscription'  => [
        'actions'               => [
            'cancel_sub'        => 'Cancelar suscripción',
            'subscribe'         => 'Suscribirse',
            'update_currency'   => 'Guardar moneda preferida',
        ],
        'billing'               => [
            'helper'    => 'Tu información de pago se procesa y se guarda de forma segura mediante :stripe. Este método de pago se usará para todas tus suscripciones.',
            'saved'     => 'Método de pago guardado',
        ],
        'cancel'                => [
            'options'   => [
                'competitor'        => 'Cambio a un competidor',
                'financial'         => 'La suscripción es demasiado cara',
                'missing_features'  => 'Faltan características',
                'not_for'           => 'La suscripción no es para mí',
                'not_playing'       => 'Ya no juego o la campaña está en pausa',
                'not_using'         => 'Actualmente no utilizo Kanka',
                'other'             => 'Otro',
            ],
            'text'      => '¡Lamentamos verte marchar! Al cancelar tu suscripción, esta seguirá activa hasta el nuevo ciclo de facturación, tras lo cual perderás tus mejoras de campaña y otros beneficios relacionados. No tengas miedo de informarnos sobre cómo podemos mejorar o qué te ha llevado a tomar esta decisión.',
        ],
        'cancelled'             => 'Se ha cancelado tu suscripción. Puedes renovarla una vez el período de la suscripción actual termine.',
        'change'                => [
            'text'  => [
                'monthly'           => 'Estás suscribiéndote al nivel :tier, que cuesta :amount mensuales.',
                'upgrade_monthly'   => 'Estás actualizando al nivel :tier por :upgrade, a partir de ahora se facturará mensualmente por :amount.',
                'upgrade_paypal'    => 'Estás actualizando al nivel :tier por :upgrade hasta :date.',
                'upgrade_yearly'    => 'Estás actualizando al nivel :tier por :upgrade, a partir de ahora, se facturará anualmente por :amount.',
                'yearly'            => 'Estás suscribiéndote al nivel :tier, que cuesta :amount anuales.',
            ],
            'title' => 'Cambiar nivel de suscripción',
        ],
        'coupon'                => [
            'check'         => 'Ver código promocional',
            'invalid'       => 'Código promocional no válido.',
            'label'         => 'Código promocional',
            'percent_off'   => '¡Tendrás un descuento del :percent% en tu primera suscripción anual!',
        ],
        'currencies'            => [
            'eur'   => 'Euros',
            'usd'   => 'Dólares estadounidenses',
        ],
        'currency'              => [
            'title' => 'Cambia la moneda de facturación',
        ],
        'errors'                => [
            'callback'      => 'Nuestro proveedor de pagos nos ha informado de un error. Por favor, vuelve a intentarlo o infórmanos si el problema persiste.',
            'failed'        => 'Estamos experimentando problemas con nuestro sistema de facturación. Por favor, ponte en contacto con nosotros en :email para obtener ayuda.',
            'subscribed'    => 'No se ha podido procesar tu suscripción. Stripe nos ha dado este mensaje:',
        ],
        'fields'                => [
            'active_since'      => 'Activa desde',
            'active_until'      => 'Activa hasta',
            'billing'           => 'Cobro',
            'currency'          => 'Moneda de cobro',
            'payment_method'    => 'Método de pago',
            'plan'              => 'Plan actual',
            'reason'            => 'Razón',
        ],
        'helpers'               => [
            'alternatives'          => 'Paga por tu suscripción usando :method. Este método de pago no se renovará automáticamente al final de tu suscripción. :method solo está disponible en euros.',
            'alternatives-2'        => 'Paga tu suscripción utilizando :method. Este pago es único y no se renueva automáticamente al final de la suscripción.',
            'alternatives_warning'  => 'No se puede mejorar la suscripción usando este método. Por favor, crea una nueva suscripción cuando la actual termine.',
            'alternatives_yearly'   => 'Debido a las restricciones de los pagos recurrentes, :method solo está disponible para las suscripciones anuales.',
            'paypal_v3'             => 'Paga tu suscripción anual de forma segura con PayPal.',
            'stripe'                => 'Tu información de facturación se procesa y almacena de forma segura a través de :stripe.',
        ],
        'manage_subscription'   => 'Gestionar suscripción',
        'payment_method'        => [
            'actions'       => [
                'add'               => 'Añadir',
                'add_new'           => 'Añadir nuevo método de pago',
                'change'            => 'Cambiar método de pago',
                'save'              => 'Guardar método de pago',
                'show_alternatives' => 'Métodos de pago alternativos',
            ],
            'add_one'       => 'Aún no tienes ningún método de pago guardado.',
            'alternatives'  => 'Puedes suscribirte usando estos métodos de pago alternativos. Esto hará un solo cobro en tu cuenta y no se renovará automáticamente cada mes.',
            'card'          => 'Tarjeta',
            'card_name'     => 'Nombre en la tarjeta',
            'country'       => 'País de residencia',
            'ending'        => 'Termina en',
            'helper'        => 'Se usará esta tarjeta para todas tus suscripciones.',
            'new_card'      => 'Añadir nuevo método de pago',
            'saved'         => ':brand que termina en :last4',
        ],
        'periods'               => [
            'monthly'   => 'Mensual',
            'yearly'    => 'Anual',
        ],
        'placeholders'          => [
            'downgrade_reason'  => 'Si lo deseas, indícanos el motivo de la reducción de categoría de tu suscripción.',
            'reason'            => 'Opcionalmente, puedes contarnos por qué ya no apoyas a Kanka. ¿Faltaba algo? ¿Cambió tu situación financiera?',
        ],
        'plans'                 => [
            'cost_monthly'  => ':amount :currency mensuales',
            'cost_yearly'   => ':amount :currency anuales',
        ],
        'sub_status'            => 'Información sobre la suscripción',
        'subscription'          => [
            'actions'   => [
                'cancel'            => 'Cancelar suscripción',
                'downgrading'       => 'Contáctanos para bajar de nivel',
                'rollback'          => 'Cambiar a Kobold',
                'subscribe'         => 'Cambiar a :tier al mes',
                'subscribe_annual'  => 'Cambiar a :tier anualmente',
            ],
        ],
        'success'               => [
            'alternative'   => 'Se ha registrado tu pago. Recibirás una notificación en cuanto terminemos de procesarlo y se active tu suscripción.',
            'callback'      => 'Tu suscripción ha tenido éxito. Tu cuenta será actualizada en cuanto nuestro proveedor de pagos nos informe del cambio (puede llevar algunos minutos).',
            'cancel'        => 'Se ha cancelado tu suscripción. Continuará activa hasta el final del período de pago.',
            'currency'      => 'Se ha actualizado tu moneda preferida.',
            'subscribed'    => 'Tu suscripción ha tenido éxito. ¡No te olvides de suscribirte a la newsletter de votaciones comunitarias para enterarte cuando se abra una votación! Puedes cambiar tu configuración de newsletters en tu perfil.',
        ],
        'tiers'                 => 'Niveles de suscripción',
        'trial_period'          => 'Las suscripciones anuales tienen un período de cancelación de 14 días. Contáctanos en :email si quieres cancelar tu suscripción anual y recuperar el dinero.',
        'upgrade_downgrade'     => [
            'button'    => 'Información acerca de subir o bajar de nivel',
            'cancel'    => [
                'bullets'   => [
                    'bonuses'   => 'Tus bonus permanecen activos hasta el final del período de facturación.',
                    'boosts'    => 'Lo mismo ocurre con tus campañas mejoradas. Las funcionalidades mejoradas se vuelven invisibles pero no se eliminan cuando dejas de mejorar la campaña.',
                    'kobold'    => 'Para cancelar la suscripción, cambia al nivel de Kobold.',
                    'premium'   => 'Lo mismo ocurre con tus campañas premium. Las funciones premium se vuelven invisibles, pero no se eliminan cuando una campaña deja de ser premium.',
                ],
                'title'     => 'Cancelar tu suscripción',
            ],
            'downgrade' => [
                'bullets'           => [
                    'end'   => 'Tu nivel actual estará activo hasta el final de tu ciclo de pago actual, tras el cual se bajará tu suscripción al nuevo nivel.',
                ],
                'provide_reason'    => 'Si puedes, por favor, comparte con nosotros por qué estás bajando de categoría tu suscripción.',
                'title'             => 'Bajar de nivel',
            ],
            'upgrade'   => [
                'bullets'   => [
                    'immediate' => 'Se cobrará en tu método de pago inmediatamente y tendrás acceso al nuevo nivel.',
                    'prorate'   => 'Al subir de nivel de Owlbear a Elemental, solo se te cobrará la diferencia entre los dos niveles.',
                ],
                'title'     => 'Subir de nivel',
            ],
        ],
        'warnings'              => [
            'incomplete'    => 'No hemos podido hacer el cobro en tu tarjeta de crédito. Por favor, actualiza la información de la tarjeta y volveremos a intentarlo en los próximos días. Si vuelve a fallar, tu suscripción será cancelada.',
            'patreon'       => 'Tu cuenta se encuentra vinculada con Patreon. Desvincúlala en la configuración de :patreon antes de cambiarla por una suscripción de Kanka.',
        ],
    ],
];
