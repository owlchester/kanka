<?php

return [
    'account'       => [
        'actions'           => [
            'social'            => 'Canvia a l\'inici de sessió des de Kanka',
            'update_email'      => 'Actualitza l\'adreça de mail',
            'update_password'   => 'Actualitza la contrasenya',
        ],
        'email'             => 'Canvia l\'adreça de mail',
        'email_success'     => 'S\'ha actualitzat l\'adreça de mail.',
        'password'          => 'Canvia la contrasenya',
        'password_success'  => 'S\'ha actualitzat la contrasenya.',
        'social'            => [
            'error'     => 'Ja esteu utilitzant l\'inici de sessió de Kanka amb aquest compte.',
            'helper'    => 'El compte està vinculat amb :provider. Podeu desvincular-la i canviar a l\'inici de sessió estàndard de Kanka escrivint una contrasenya.',
            'success'   => 'El compte ara fa servir l\'inici de sessió de Kanka.',
            'title'     => 'De social a Kanka',
        ],
        'title'             => 'Compte',
    ],
    'api'           => [
        'experimental'          => 'Benvingut a les APIs de Kanka! Aquestes prestacions encara són experimentals però haurien de ser prou estables perquè permetin comunicar-se amb les APIs. Creeu un Token d\'Accés Personal per a usar a les vostres sol·licituds d\'API, o useu el Token Client si voleu que la vostra app tingui accés a dades d\'usuari.',
        'help'                  => 'Kanka oferirà pròximament una RESTful API perquè aplicacions terceres puguin connectar-se a l\'app. Aquí s\'aniran mostrant els detalls sobre com gestionar les claus API.',
        'link'                  => 'Llegeix la documentació de l\'API',
        'request_permission'    => 'Actualment estem construint una poderosa RESTful API perquè aplicacions terceres puguin connectar-se a l\'app. No obstant això, de moment limitem el nombre d\'usuaris que poden interactuar amb la API mentre la polim. Si voleu accedir a l\'API i construir apps interessants que interactuin amb Kanka, contacteu-nos i us enviarem tota la informació que calgui.',
        'title'                 => 'API',
    ],
    'apps'          => [
        'actions'   => [
            'connect'   => 'Connecta',
            'remove'    => 'Elimina',
        ],
        'benefits'  => 'Kanka ofereix algunes integracions amb serveis de tercers. Hi ha més integracions planejades per al futur.',
        'discord'   => [
            'errors'    => [
                'add'   => 'Hi ha hagut un error vinculant el vostre compte de Discord amb Kanka. Si us plau, torneu a intentar-ho.',
            ],
            'success'   => [
                'add'       => 'S\'ha vinculat el vostre compte de Discord.',
                'remove'    => 'S\'ha desvinculat el vostre compte de Discord.',
            ],
            'text'      => 'Accediu als rols de subscripció automàticament.',
        ],
        'title'     => 'Integració d\'aplicacions',
    ],
    'boost'         => [
        'benefits'      => [
            'first'     => 'Per a assegurar un progrés continu a Kanka, algunes característiques de la campanya es poden desbloquejar millorant-la. Les millores es desbloquegen a través de les subscripcions. Qualsevol que pugui veure una campanya pot millorar-la; així el màster no ha de pagar sempre el compte. Una campanya roman millorada mentre un usuari l\'estigui millorant i continuï fent suport a Kanka. Si una campanya deixa d\'estar millorada, les dades no es perden: només romanen ocultes fins que la campanya torni a ser millorada.',
            'header'    => 'Imatges de capçalera per a les entitats.',
            'images'    => 'Imatges per defecte personalitzades',
            'more'      => 'Saber més sobre totes les característiques.',
            'second'    => 'Millorar una campanya activa els següents beneficis:',
            'theme'     => 'Tema i estil personalitzat a nivell de campanya.',
            'third'     => 'Per a millorar una campanya, dirigiu-vos a la pàgina de la campanya i cliqueu el botó de ":boost_button" que hi ha sobre el botó de ":edit_button".',
            'tooltip'   => 'Descripcions emergents personalitzades per a les entitats.',
            'upload'    => 'Capacitat de pujada d\'arxius ampliada per a tots els membres de la campanya.',
        ],
        'buttons'       => [
            'boost' => 'Millora',
        ],
        'campaigns'     => 'Campanyes millorades :count/:max',
        'exceptions'    => [
            'already_boosted'   => 'La campanya :name ja està millorada.',
            'exhausted_boosts'  => 'Us heu quedat sense millores. Elimineu una millora d\'una campanya abans de donar-la-hi a una altra.',
        ],
        'success'       => [
            'boost' => 'S\'ha millorat la campanya :name.',
            'delete'=> 'La vostra millora s\'ha tret de :name.',
        ],
        'title'         => 'Millorar',
    ],
    'countries'     => [
        'austria'       => 'Àustria',
        'belgium'       => 'Bèlgica',
        'france'        => 'França',
        'germany'       => 'Alemanya',
        'italy'         => 'Itàlia',
        'netherlands'   => 'Països Baixos',
        'spain'         => 'Espanya',
    ],
    'invoices'      => [
        'actions'   => [
            'download'  => 'Descarrega el PDF',
            'view_all'  => 'Veu-les totes',
        ],
        'empty'     => 'Sense factures',
        'fields'    => [
            'amount'    => 'Quantitat',
            'date'      => 'Data',
            'invoice'   => 'Factura',
            'status'    => 'Estat',
        ],
        'header'    => 'Podeu descarregar les últimes 24 factures a continuació.',
        'status'    => [
            'paid'      => 'Pagada',
            'pending'   => 'Pendent',
        ],
        'title'     => 'Factures',
    ],
    'layout'        => [
        'success'   => 'S\'han actualitzat les opcions de disseny.',
        'title'     => 'Disseny',
    ],
    'menu'          => [
        'account'               => 'Compte',
        'api'                   => 'API',
        'apps'                  => 'Aplicacions',
        'billing'               => 'Mètode de pagament',
        'boost'                 => 'Millorar',
        'invoices'              => 'Factures',
        'layout'                => 'Disseny',
        'other'                 => 'Altres',
        'patreon'               => 'Patreon',
        'payment_options'       => 'Opcions de pagament',
        'personal_settings'     => 'Configuració personal',
        'profile'               => 'Perfil',
        'subscription'          => 'Subscripció',
        'subscription_status'   => 'Estat de la subscripció',
    ],
    'patreon'       => [
        'actions'           => [
            'link'  => 'Vincula el compte',
            'view'  => 'Visita la pàgina de Patreon de Kanka',
        ],
        'benefits'          => 'Fer-nos suport a Patreon desbloqueja moltes :features per a les campanyes, i ens ajuda a dedicar-li més temps a treballar en Kanka.',
        'benefits_features' => 'funcions increïbles',
        'deprecated'        => 'Funcionalitat discontinuada. Si desitgeu fer suport a Kanka, podeu fer-ho mitjançant una :subscription. La vinculació amb Patreon encara continua activa per als nostres Patrons que van vincular els seus comptes abans de la mudança de Patreon.',
        'description'       => 'Sincronizant amb Patreon',
        'errors'            => [
            'invalid_token' => 'Token no vàlid! Patreon no ha pogut validar la vostra petició.',
            'missing_code'  => 'Manca el codi! Patreon no ha enviat un codi per a identificar el vostre compte.',
            'no_pledge'     => 'Sense "pledge"! Patreon ha identificat el vostre compte, però no detecta cap "pledge" actiu.',
        ],
        'link'              => 'Cliqueu següent botó si esteu fent suport a Kanka en Patreon actualment. Això us donarà accés a més coses fantàstiques extres!',
        'linked'            => 'Gràcies per fer suport a Kanka en Patreon! S\'ha vinculat el vostre compte.',
        'pledge'            => 'Pledge :name',
        'remove'            => [
            'button'    => 'Desvincula el meu compte de Patreon',
            'success'   => 'S\'ha desvinculat el vostre compte de Patreon.',
            'text'      => 'Desvincular el vostre compte de Patreon de Kanka eliminarà els vostres bonus, el vostre nom del saló de la fama, les vostres millores i altres funcionalitats vinculades. No obstant això, el vostre contingut millorat no es perdrà: si torneu a subscriure-us, tornareu a tenir accés a aquestes dades, incloent la possibilitat de tornar a millorar aquesta campanya.',
            'title'     => 'Desvincular el compte de Patreon de Kanka',
        ],
        'success'           => 'Gràcies per fer suport a Kanka a Patreon!',
        'title'             => 'Patreon',
        'wrong_pledge'      => 'Afegim manualment el vostre nivell de "pledge", així que tingueu en compte que podem trigar uns pocs dies. Si al cap d\'un temps segueix sense estar bé, contacteu amb nosaltres.',
    ],
    'profile'       => [
        'actions'   => [
            'update_profile'    => 'Actualiza el perfil',
        ],
        'avatar'    => 'Foto de perfil',
        'success'   => 'S\'ha actualitzat el perfil.',
        'title'     => 'Perfil personal',
    ],
    'subscription'  => [
        'actions'               => [
            'cancel_sub'        => 'Cancela la subscripció',
            'subscribe'         => 'Subscriu-me',
            'update_currency'   => 'Guarda com a moneda preferida',
        ],
        'benefits'              => 'En donar-nos suport, es desbloquegen noves :features i ens ajudeu a dedicar més temps a la millora de Kanka. No es guarda cap informació bancària. Usem :stripe per a gestionar els cobraments.',
        'billing'               => [
            'helper'    => 'La vostra informació de pagament es processa i es guarda de manera segura mitjançant :stripe. Aquest mètode de pagament s\'usarà per a totes les vostres subscripcions.',
            'saved'     => 'Mètode de pagament guardat',
            'title'     => 'Edita el mètode de pagament',
        ],
        'cancel'                => [
            'text'  => 'Ens sap greu que marxeu! En cancel·lar la vostra subscripció, aquesta continuarà activa fins al nou cicle de facturació, després del qual perdreu les millores de campanya i altres beneficis relacionats. No dubteu en informar-nos sobre com podem millorar o què us ha dut a prendre aquesta decisió.',
        ],
        'cancelled'             => 'S\'ha cancel·lat la subscripció. Podeu renovar-la una vegada el període de la subscripció actual hagi acabat.',
        'change'                => [
            'text'  => [
                'monthly'   => 'Us esteu subscrivint al nivell :tier, que costa :amount mensuals.',
                'yearly'    => 'Us esteu subscrivint al nivell :tier, que costa :amount anuals.',
            ],
            'title' => 'Canvia el nivell de subscripció',
        ],
        'currencies'            => [
            'eur'   => 'Euros',
            'usd'   => 'Dòlars estatunidencs',
        ],
        'currency'              => [
            'title' => 'Canvia la moneda de facturació',
        ],
        'errors'                => [
            'callback'      => 'El nostre proveïdor de pagaments ens ha informat d\'un error. Si us plau, torneu a intentar-ho o informeu-nos si el problema persisteix.',
            'subscribed'    => 'No s\'ha pogut processar la subscripció. Stripe ens ha donat aquest missatge:',
        ],
        'fields'                => [
            'active_since'      => 'Activa des del',
            'active_until'      => 'Activa fins el',
            'billing'           => 'Cobrament',
            'currency'          => 'Moneda de cobrament',
            'payment_method'    => 'Mètode de pagament',
            'plan'              => 'Pla actual',
            'reason'            => 'Raó',
        ],
        'helpers'               => [
            'alternatives'          => 'Paga per la subscripció usant :method. Aquest mètode de pagament no es renovarà automàticament al final de la subscripció. :method només està disponible amb euros.',
            'alternatives_warning'  => 'No es pot millorar la subscripció usant aquest mètode. Si us plau, feu una nova subscripció quan l\'actual acabi.',
            'alternatives_yearly'   => 'A causa de les restriccions dels pagaments recurrents, :method només està disponible per a les subscripcions anuals.',
        ],
        'manage_subscription'   => 'Gestiona la subscripció',
        'payment_method'        => [
            'actions'       => [
                'add_new'           => 'Afegeix un nou mètode de pagament',
                'change'            => 'Canvia el mètode de pagament',
                'save'              => 'Guarda el mètode de pagament',
                'show_alternatives' => 'Mètodes de pagament alternatius',
            ],
            'add_one'       => 'Encara no teniu cap mètode de pagament guardat.',
            'alternatives'  => 'Podeu subscriure-us usant aquests mètodes de pagament alternatius. Això farà un sol cobrament al vostre compte i no es renovarà automàticament cada mes.',
            'card'          => 'Targeta',
            'card_name'     => 'Nom a la targeta',
            'country'       => 'País de residència',
            'ending'        => 'Acaba en',
            'helper'        => 'S\'usarà aquesta targeta per a totes les vostres subscripcions.',
            'new_card'      => 'Afegeix un nou mètode de pagament',
            'saved'         => ':brand que acaba en :last4',
        ],
        'placeholders'          => [
            'reason'    => 'Opcionalment, podeu explicar-nos per què ja no feu suport a Kanka. Que faltava alguna cosa? Va canviar la vostra situació financera?',
        ],
        'plans'                 => [
            'cost_monthly'  => ':amount :currency mensuals',
            'cost_yearly'   => ':amount :currency anuals',
        ],
        'sub_status'            => 'Informació sobre la subscripció',
        'subscription'          => [
            'actions'   => [
                'downgrading'       => 'Contacteu-nos per a baixar de nivell',
                'rollback'          => 'Canvia a Kobold',
                'subscribe'         => 'Canvia a :tier mensualment',
                'subscribe_annual'  => 'Canvia a :tier anualmente',
            ],
        ],
        'success'               => [
            'alternative'   => 'S\'ha registrat el pagament. Rebreu una notificació quan acabem de processar-ho i s\'activi la subscripció.',
            'callback'      => 'La subscripció ha tingut èxit. El vostre compte s\'actualitzarà quan el nostre proveïdor de pagaments ens informi del canvi (pot portar alguns minuts).',
            'cancel'        => 'S\'ha cancel·lat la vostra subscripció. Continuarà activa fins al final del període de pagament.',
            'currency'      => 'S\'ha actualitzat la vostra moneda preferida.',
            'subscribed'    => 'La subscripció ha tingut èxit. No oblideu subscriure-us a la newsletter de votacions comunitàries per a assabentar-vos quan s\'obri una votació! Podeu canviar la configuració de newsletters des del perfil.',
        ],
        'tiers'                 => 'Nivells de subscripció',
        'trial_period'          => 'Les subscripcions anuals tenen un període de cancel·lació de 14 dies. Contacteu-nos per :email si vols cancel·lar la subscripció anual i recuperar els diners.',
        'upgrade_downgrade'     => [
            'button'    => 'Informació sobre pujar o baixar de nivell',
            'downgrade' => [
                'bullets'   => [
                    'end'   => 'El vostre nivell actual estarà actiu fins al final del cicle de pagament actual, després del qual es baixarà la subscripció al nou nivell.',
                ],
                'title'     => 'Baixar de nivell',
            ],
            'upgrade'   => [
                'bullets'   => [
                    'immediate' => 'Es cobrarà amb el vostre mètode de pagament immediatament i tindreu accés al nou nivell.',
                    'prorate'   => 'En pujar de nivell de Owlbear a Elemental, només es cobrarà la diferència entre els dos nivells.',
                ],
                'title'     => 'Pujar de nivell',
            ],
        ],
        'warnings'              => [
            'incomplete'    => 'No hem pogut fer el cobrament a la vostra targeta de crèdit. Si us plau, actualitzeu la informació de la targeta i tornarem a intentar-ho en els pròxims dies. Si torna a fallar, la  subscripció serà cancel·lada.',
            'patreon'       => 'El vostre compte es troba vinculat amb Patreon. Desvinculeu-lo des de la configuració de :patreon abans de canviar-la per una subscripció de Kanka.',
        ],
    ],
];
