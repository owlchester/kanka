<?php

return [
    'account'       => [
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
        ],
        'title'     => 'Integración en aplicacións',
    ],
    'boost'         => [
        'available_boosts'  => 'Potenciadores dispoñíbeis: :amount / :max',
        'benefits'          => [
            'campaign_gallery'  => 'Unha galería de campaña para subir imaxes que podes reutilizar en calquera lugar da campaña.',
            'entity_files'      => 'Sube ata 10 arquivos por entidade.',
            'entity_logs'       => 'Rexistros completos de todo o que cambiou nunha entidade en cada actualización.',
            'first'             => 'Para asegurar o progreso continuado de Kanka, algunhas funcionalidades son desbloqueadas potenciando unha campaña. Os potenciadores son desbloqueados a través de subscripcións. Calquera persoa que pode ver unha campaña pode potenciala, para que a directora de xogo non teña que ser sempre quen paga. Unha campaña permanece potenciada sempre que haxa unha persoa que a estea potenciando e esa persoa teña unha subscripción. Se unha campaña deixa de estar potenciada, os datos non se perden, senón que quedan ocultos ata que a campaña sexa potenciada de novo.',
            'header'            => 'Imaxes de cabeceira nas entidades.',
            'headers'           => [
                'boosted'       => 'Beneficios dunha campaña potenciada',
                'superboosted'  => 'Beneficios dunha campaña superpotenciada',
            ],
            'helpers'           => [
                'boosted'       => 'Potenciar unha campaña asigna un único potenciador á campaña.',
                'superboosted'  => 'Superpotenciar unha campaña asigna un total de tres potenciadores á campaña.',
            ],
            'images'            => 'Imaxes de entidade por defecto personalizábeis.',
            'more'              => [
                'boosted'       => 'Todas as funcionalidades dunha campaña potenciada',
                'superboosted'  => 'Todas as funcionalidades dunha campaña superpotenciada',
            ],
            'recovery'          => 'Recuperar entidades eliminadas ata :amount días antes.',
            'superboost'        => 'Superpotenciar unha campaña usa 3 dos teus potenciadores e desbloquea funcionalidades adicionais a parte das que xa teñen as campañas potenciadas.',
            'theme'             => 'Tema e estilo personalizado a nivel de campaña.',
            'third'             => 'Para potenciar unha campaña, vai á súa páxina e fai clic no botón :boost_button enriba do botón :edit_button.',
            'tooltip'           => 'Previsualizacións emerxentes personalizadas para as entidades.',
            'upload'            => 'Tamaño máximo de subida aumentado para toda persoa integrante da campaña.',
        ],
        'buttons'           => [
            'boost'         => 'Potenciar',
            'superboost'    => 'Superpotenciar',
            'tooltips'      => [
                'boost'         => 'Potenciar unha campaña usa :amount dos teus potenciadores',
                'superboost'    => 'Superpotenciar unha campaña usa :amount dos teus potenciadores',
            ],
            'unboost'       => 'Despotenciar',
        ],
        'campaigns'         => 'Campañas potenciadas :count / :max',
        'exceptions'        => [
            'already_boosted'       => 'A campaña ":name" xa está potenciada.',
            'exhausted_boosts'      => 'Non che quedan potenciadores. Elimina o teu potenciador dunha campaña antes de darllo a outra.',
            'exhausted_superboosts' => 'Non che quedan potenciadores. Precisas 3 potenciadores para superpotenciar unha campaña.',
        ],
        'modals'            => [
            'more'  => [
                'action'    => 'Máis potenciadores?',
                'body'      => 'Podes obter máis potenciadores aumentando o teu nivel de subscripción, ou despotenciando unha campaña. Despotenciar unha campaña non elimina ningún dato, só os deshabilita ata que a volvas potenciar.',
                'title'     => 'Conseguir máis potenciadores',
            ],
        ],
        'success'           => [
            'boost'         => 'Campaña ":name" potenciada.',
            'delete'        => 'Quitouse o teu potenciador de ":name".',
            'superboost'    => 'Campaña ":name" superpotenciada.',
        ],
        'title'             => 'Potenciar',
        'unboost'           => [
            'description'   => 'Tes certeza de que queres deixar de potenciar a campaña ":tag"?',
            'title'         => 'Despotenciando unha campaña',
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
    'invoices'      => [
        'actions'   => [
            'download'  => 'Descargar PDF',
            'view_all'  => 'Ver todo',
        ],
        'empty'     => 'Sen facturas',
        'fields'    => [
            'amount'    => 'Cantidade',
            'date'      => 'Data',
            'invoice'   => 'Factura',
            'status'    => 'Estado',
        ],
        'header'    => 'Abaixo tes unha lista coas túas últimas 24 facturas que poden ser descargadas.',
        'status'    => [
            'paid'      => 'Pagada',
            'pending'   => 'Pendente',
        ],
        'title'     => 'Facturas',
    ],
    'layout'        => [
        'success'   => 'Opcións de deseño actualizadas.',
        'title'     => 'Deseño',
    ],
    'marketplace'   => [
        'fields'    => [
            'name'  => 'Nome no Mercado',
        ],
        'helper'    => 'Por defecto, o nome da túa conta é o mostrado no :marketplace. Podes modificalo neste campo.',
        'title'     => 'Configuración do Mercado',
        'update'    => 'Configuración do Mercado gardada.',
    ],
    'menu'          => [
        'account'               => 'Conta',
        'api'                   => 'API',
        'apps'                  => 'Aplicacións',
        'billing'               => 'Método de pagamento',
        'boost'                 => 'Potenciar',
        'invoices'              => 'Facturas',
        'layout'                => 'Deseño',
        'marketplace'           => 'Mercado',
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
        'description'   => 'Sincronizando con Patreon',
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
        'benefits'              => 'Apoiándonos podes desbloquear algunhas :features e axudarnos a dedicar máis tempo a mellorar Kanka. Non gardamos ningunha información de cartóns de crédito, usamos :stripe para xestionar os pagamentos.',
        'benefits_features'     => 'incríbeis funcionalidades',
        'billing'               => [
            'helper'    => 'A túa información de pagamento é procesada e almacenada de forma segura a través de :stripe. O teu método de pagamento é usado para todas as túas subscripcións.',
            'saved'     => 'Método de pagamento gardado',
            'title'     => 'Editar método de pagamento',
        ],
        'cancel'                => [
            'text'  => 'Lamentamos verte marchar! Cancelar a túa subscripción manteraa activa ata o próximio ciclo de facturación, tras o cal perderás todas as túas potenciacións de campaña e outros beneficios ligados a apoiar a Kanka. Podes cubrir o seguinte formulario para informarnos de como podemos mellorar, ou do que causou a túa decisión.',
        ],
        'cancelled'             => 'A túa subscripción foi cancelada. Podes renovala unha vez a subcripción actual termine.',
        'change'                => [
            'text'  => [
                'monthly'   => 'Estás subscribíndote ao nivel :tier, pagando :amount mensualmente.',
                'yearly'    => 'Estás subscribíndote ao nivel :tier, pagando :amount anualmente.',
            ],
            'title' => 'Cambiar nivel de subscripción',
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
            'alternatives'          => 'Paga a túa subscripción usando :method. Este método de pagamento non se renovará automáticamente ao final da túa subscripción. :method só está dispoñíbel en Euros.',
            'alternatives_warning'  => 'Mellorar a túa subscripción usando este método non é posíbel. Por favor, crea unha nova subscripción ao rematar a actual.',
            'alternatives_yearly'   => 'Debido a restricións nos pagamentos recurrentes, :method só está dispoíbel para subcripcións anuais.',
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
        'placeholders'          => [
            'reason'    => 'Opcionalmente, cóntanos por que deixas de apoiar a Kanka. Faltouche algunha función? Cambiou a túa situación financieira?',
        ],
        'plans'                 => [
            'cost_monthly'  => ':amount :currency cobrados mensualmente',
            'cost_yearly'   => ':amount :currency cobrados anualmente',
        ],
        'sub_status'            => 'Información da subscripción',
        'subscription'          => [
            'actions'   => [
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
                    'boosts'    => 'O mesmo pasa coas túas campañas potenciadas. Unha vez a campaña deixa de estar potenciada, as funcionalidades da potenciación fanse invisíbeis mais non son eliminadas.',
                    'kobold'    => 'Para cancelar a túa subscripción, cambia ao nivel Kobold.',
                ],
                'title'     => 'Ao cancelar a túa subscripción',
            ],
            'downgrade' => [
                'bullets'   => [
                    'end'   => 'O teu nivel actual permanecerá activo ata o final do teu actual periodo de pagamento, despois do cal serás baixado ao teu novo nivel.',
                ],
                'title'     => 'Ao cambiar a un nivel máis baixo',
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
