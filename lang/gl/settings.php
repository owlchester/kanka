<?php

return [
    'account'       => [
        '2fa'               => [
            'actions'               => [
                'disable'   => 'Desactivar a autenticación en dous factores',
                'finish'    => 'Rematar a configuración e iniciar sesión',
            ],
            'activation_helper'     => 'Para rematar de configurar a autenticación en dous factores, sigue as seguintes instrucións.',
            'disable'               => [
                'helper'    => 'Se queres desactivar a autenticación en dous factores, fai clic no botón de abaixo. Lembra que isto deixará a túa conta vulnerable a calquera persoa que saiba a túa información de inicio de sesión.',
                'title'     => 'Desactivar a autenticación en dous factores',
            ],
            'enable_instructions'   => 'Para iniciar o proceso de activación, xera o teu código QR de autenticación, e logo escanéao na aplicación de Google Authenticator (:ios, :andoid) ou noutra aplicación de autenticación similar.',
            'enabled'               => 'A autenticación en dous factores está actualmente activada na túa conta.',
            'error_enable'          => 'Código non válido, inténtao de novo',
            'fields'                => [
                'otp'       => 'Introduce o contrasinal único (OTP) dado pola túa aplicación autenticadora.',
                'qrcode'    => 'Escanea o seguinte código QR coa túa aplicación autenticadora para xerar un contrasinal único (OTP).',
            ],
            'generate_qr'           => 'Xerar código QR',
        ],
        'actions'           => [
            'social'            => 'Cambiar a inicio de sesión con Kanka',
            'update_email'      => 'Actualizar enderezo de correo electrónico',
            'update_password'   => 'Actualizar contrasinal',
        ],
        'email'             => 'Cambiar enderezo de correo electrónico',
        'email_success'     => 'Enderezo de correo electrónico actualizada.',
        'password'          => 'Cambiar contrasinal',
        'password_success'  => 'Contrasinal actualizado.',
        'social'            => [
            'error'     => 'Xa estás iniciando sesión con Kanka nesta conta.',
            'helper'    => 'A túa conta está actualmente xestionada por :provider. Podes cambialo e usar o inicio corrente de sesión con Kanka establecendo un contrasinal.',
            'success'   => 'A túa conta usa agora o inicio de sesión con Kanka.',
            'title'     => 'De social a Kanka',
        ],
        'title'             => 'Conta',
    ],
    'api'           => [
        'helper'    => 'Dámosche a benvida ás APIs de Kanka. Xera un token de acceso persoal para usar na túa solicitude API e reunir información das campañas das que es parte.',
        'link'      => 'Ler a documentación da API',
        'title'     => 'API',
    ],
    'apps'          => [
        'actions'   => [
            'connect'   => 'Conectar',
            'remove'    => 'Eliminar',
        ],
        'benefits'  => 'Kanka proporciona unhas cantas integracións en servizos de terceiros. Máis integracións están planeadas para o futuro.',
        'discord'   => [
            'errors'    => [
                'add'   => 'Ocorreu un erro ao ligar a túa conta de Discord a Kanka. Por favor, inténtao de novo.',
            ],
            'success'   => [
                'add'       => 'A túa conta de Discord foi ligada.',
                'remove'    => 'A túa conta de Discord foi desligada.',
            ],
            'text'      => 'Accede aos teus roles de subscripción automáticamente.',
            'unlock'    => 'Desbloquear roles de Discord',
        ],
        'title'     => 'Integración en aplicacións',
    ],
    'boost'         => [
        'exceptions'    => [
            'already_boosted'       => 'A campaña ":name" xa está potenciada.',
            'exhausted_boosts'      => 'Non che quedan potenciadores. Elimina o teu potenciador dunha campaña antes de darllo a outra.',
            'exhausted_superboosts' => 'Non che quedan potenciadores. Precisas 3 potenciadores para superpotenciar unha campaña.',
        ],
    ],
    'countries'     => [
        'austria'       => 'Austria',
        'belgium'       => 'Bélxica',
        'france'        => 'Francia',
        'germany'       => 'Alemania',
        'italy'         => 'Italia',
        'netherlands'   => 'Países Baixos',
        'spain'         => 'España',
    ],
    'invoices'      => [],
    'layout'        => [
        'title' => 'Deseño',
    ],
    'marketplace'   => [],
    'menu'          => [
        'account'               => 'Conta',
        'api'                   => 'API',
        'appearance'            => 'Aparencia',
        'apps'                  => 'Aplicacións',
        'boosters'              => 'Potenciadores',
        'notifications'         => 'Notificacións',
        'other'                 => 'Miscelánea',
        'patreon'               => 'Patreon',
        'payment_options'       => 'Opcións de pagamento',
        'personal_settings'     => 'Axustes persoais',
        'profile'               => 'Perfil',
        'settings'              => 'Configuración',
        'subscription'          => 'Subscripción',
        'subscription_status'   => 'Estado da subscripción',
    ],
    'patreon'       => [
        'deprecated'    => 'Funcionalidade obsoleta - se desexas apoiar a Kanka, por favor, faino con unha subscripción. A ligazón de contas de Patreon aínda está activa para as persoas que ligaron a súa conta previamente a que deixásemos de usar Patreon.',
        'pledge'        => 'Pledge :name',
        'remove'        => [
            'button'    => 'Desligar a túa conta de Patreon',
            'success'   => 'A túa conta de Patreon foi desligada.',
            'text'      => 'Desligar a túa conta de Patreon eliminará as túas bonificacións, nome do salón da fama, potenciacións de campaña, e outras funcionalidades ligadas a apoiar a Kanka. Ningún do teu contido será eliminado. Subscribíndote de novo terás acceso a todos os teus datos previos, incluíndo a habilidade de potenciar as campañas que potenciaras previamente.',
            'title'     => 'Desliga a túa conta de Patreon',
        ],
        'title'         => 'Patreon',
    ],
    'profile'       => [
        'actions'   => [
            'update_profile'    => 'Actualizar perfil',
        ],
        'avatar'    => 'Imaxe de perfil',
        'success'   => 'Perfil actualizado.',
        'title'     => 'Perfil persoal',
    ],
    'subscription'  => [
        'actions'               => [
            'cancel_sub'        => 'Cancelar subscripción',
            'subscribe'         => 'Subscribirse',
            'update_currency'   => 'Gardar moeda preferida',
        ],
        'billing'               => [
            'helper'    => 'A túa información de pagamento é procesada e almacenada de forma segura a través de :stripe. O teu método de pagamento é usado para todas as túas subscripcións.',
            'saved'     => 'Método de pagamento gardado',
        ],
        'cancel'                => [
            'options'   => [
                'competitor'        => 'Marcho á competencia',
                'financial'         => 'Cambio a miña situación financieira',
                'missing_features'  => 'Faltan funcionalidades',
                'not_for'           => 'A subscripción non é para min',
                'not_using'         => 'Non estou usando Kanka',
                'other'             => 'Outros',
            ],
            'text'      => 'Lamentamos verte marchar! Cancelar a túa subscripción manteraa activa ata o próximio ciclo de facturación, tras o cal perderás todas as túas potenciacións de campaña e outros beneficios ligados a apoiar a Kanka. Podes cubrir o seguinte formulario para informarnos de como podemos mellorar, ou do que causou a túa decisión.',
        ],
        'cancelled'             => 'A túa subscripción foi cancelada. Podes renovala unha vez a subcripción actual termine.',
        'change'                => [
            'text'  => [
                'monthly'   => 'Estás subscribíndote ao nivel :tier, pagando :amount mensualmente.',
                'yearly'    => 'Estás subscribíndote ao nivel :tier, pagando :amount anualmente.',
            ],
            'title' => 'Cambiar nivel de subscripción',
        ],
        'coupon'                => [
            'check'         => 'Verificar código promocional',
            'invalid'       => 'O código promocional non é válido.',
            'label'         => 'Código promocional',
            'percent_off'   => 'Descontaremos un :percent% da túa primeira subscrición anual!',
        ],
        'currencies'            => [
            'eur'   => 'EUR',
            'usd'   => 'USD',
        ],
        'currency'              => [
            'title' => 'Cambia a túa moeda de pagamento preferida',
        ],
        'errors'                => [
            'callback'      => 'O noso provedor de pagamento reportou un erro. Por favor, inténtao de novo ou contacta connosco se o problema persiste.',
            'subscribed'    => 'A túa subscripción non puido ser procesada. Stripe proporcionou a seguinte suxestión.',
        ],
        'fields'                => [
            'active_since'      => 'Activa dende',
            'active_until'      => 'Activa ata',
            'billing'           => 'Cobramento',
            'currency'          => 'Moeda de cobramento',
            'payment_method'    => 'Método de pagamento',
            'plan'              => 'Plan actual',
            'reason'            => 'Razón',
        ],
        'helpers'               => [
            'alternatives'          => 'Paga a túa subscripción usando :method. Este método de pagamento non se renovará automáticamente ao final da túa subscripción. :method só está dispoñible en Euros.',
            'alternatives_warning'  => 'Mellorar a túa subscripción usando este método non é posible. Por favor, crea unha nova subscripción ao rematar a actual.',
            'alternatives_yearly'   => 'Debido a restricións nos pagamentos recurrentes, :method só está dispoñible para subcripcións anuais.',
            'paypal'                => 'Prefires usar Paypal? Contáctanos en :email se desexas subscribirte a un plan anual usando Paypal.',
            'stripe'                => 'A túa información de facturación é procesada e almacenada de xeito seguro mediante :stripe.',
        ],
        'manage_subscription'   => 'Xestionar subscripción',
        'payment_method'        => [
            'actions'       => [
                'add_new'           => 'Engadir novo método de pagamento',
                'change'            => 'Cambiar método de pagamento',
                'save'              => 'Gardar método de pagamento',
                'show_alternatives' => 'Opcións de pagamento alternativas',
            ],
            'add_one'       => 'Actualmente non tes métodos de pagamento gardados.',
            'alternatives'  => 'Podes subscribirte usando estos métodos de pagamento alternativos. Esta acción cobrará da túa conta unha soa vez e non autorenovará a túa subscripción cada mes.',
            'card'          => 'Cartón',
            'card_name'     => 'Nome no cartón',
            'country'       => 'País de residencia',
            'ending'        => 'Terminado en',
            'helper'        => 'Este cartón será usado para todas as túas subscripcións.',
            'new_card'      => 'Engadir un novo método de pagamento',
            'saved'         => ':brand terminado en :last4',
        ],
        'periods'               => [
            'monthly'   => 'Mensual',
            'yearly'    => 'Anual',
        ],
        'placeholders'          => [
            'downgrade_reason'  => 'Opcionalmente, cóntanos por que estás reducindo a túa subscripción.',
            'reason'            => 'Opcionalmente, cóntanos por que deixas de apoiar a Kanka. Faltouche algunha función? Cambiou a túa situación financieira?',
        ],
        'plans'                 => [
            'cost_monthly'  => ':amount :currency cobrados mensualmente',
            'cost_yearly'   => ':amount :currency cobrados anualmente',
        ],
        'sub_status'            => 'Información da subscripción',
        'subscription'          => [
            'actions'   => [
                'cancel'            => 'Cancelar subscripción',
                'downgrading'       => 'Por favor, contacta connosco para baixar o nivel da subscripción',
                'rollback'          => 'Cambiar a Kobold',
                'subscribe'         => 'Cambiar a :tier mensual',
                'subscribe_annual'  => 'Cambiar a :tier anual',
            ],
        ],
        'success'               => [
            'alternative'   => 'O teu pagamento foi rexistrado. Recibirás unha notificación en canto sexa procesado e a túa subscripción estea activa.',
            'callback'      => 'A túa subscripción foi exitosa. A túa conta será actualizada en canto o noso provedor de pagamento nos informe do cambio (pode levar uns minutos).',
            'cancel'        => 'A túa subcripción foi cancelada. Continuará estando activa ata o final do actual periodo de pagamento.',
            'currency'      => 'A túa moeda preferida foi actualizada.',
            'subscribed'    => 'A túa subscripción foi exitosa. Non esquezas subscribirte ao boletín de información para recibir notificacións cada vez que haxa unha votación da comunidade. Podes cambiar a túa configuración de boletíns de información nos axustes do teu Perfil.',
        ],
        'tiers'                 => 'Niveis de subscripción',
        'trial_period'          => 'As subscripcións anuais teñen unha política de cancelación de 14 días. Contacta connosco en :email se desexas cancelar a túa subscripción anual e che devolvamos o diñeiro.',
        'upgrade_downgrade'     => [
            'button'    => 'Cambiar o nivel de subscripción',
            'cancel'    => [
                'bullets'   => [
                    'bonuses'   => 'Os teus beneficios continúan habilitados ata o final do teu periodo de pagamento.',
                    'boosts'    => 'O mesmo pasa coas túas campañas potenciadas. Unha vez a campaña deixa de estar potenciada, as funcionalidades da potenciación fanse invisibles mais non son eliminadas.',
                    'kobold'    => 'Para cancelar a túa subscripción, cambia ao nivel Kobold.',
                ],
                'title'     => 'Ao cancelar a túa subscripción',
            ],
            'downgrade' => [
                'bullets'           => [
                    'end'   => 'O teu nivel actual permanecerá activo ata o final do teu actual periodo de pagamento, despois do cal serás baixado ao teu novo nivel.',
                ],
                'provide_reason'    => 'Por favor, comparte connosco o motivo polo que estás reducindo a túa subscripción.',
                'title'             => 'Ao cambiar a un nivel máis baixo',
            ],
            'upgrade'   => [
                'bullets'   => [
                    'immediate' => 'O teu método de pagamento será cobrado inmediatamente e terás acceso ao teu novo nivel.',
                    'prorate'   => 'Ao subir dende Owlbear a Elemental, só se che cobrará a diferenza ata o novo nivel.',
                ],
                'title'     => 'Ao cambiar a un nivel máis alto',
            ],
        ],
        'warnings'              => [
            'incomplete'    => 'Non puidemos cobrar do teu cartón de crédito. Por favor, actualiza a información do teu cartón, e tentaremos cobrar de novo nos próximos días. Se falla de novo, a túa subscripción será cancelada.',
            'patreon'       => 'A túa conta está actualmente ligada a Patreon. Por favor, deslígaa na configuración do teu :patreon antes de cambiar a unha subscripción de Kanka.',
        ],
    ],
];
