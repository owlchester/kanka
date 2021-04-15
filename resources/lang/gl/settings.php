<?php

return [
    'account'   => [
        'actions'           => [
            'social'            => 'Cambiar a inicio de sesión con Kanka',
            'update_email'      => 'Actualizar dirección de correo electrónico',
            'update_password'   => 'Actualizar contrasinal',
        ],
        'email'             => 'Cambiar dirección de correo electrónico',
        'email_success'     => 'Dirección de correo electrónico actualizada.',
        'password'          => 'Cambiar contrasinal',
        'password_success'  => 'Contrasinal actualizado.',
        'social'            => [
            'error'     => 'Xa estás iniciando sesión con Kanka nesta conta.',
            'helper'    => 'A túa conta está actualmente xestionada por :provider. Podes cambialo e usar o inicio corriente de sesión con Kanka establecendo un contrasinal.',
            'success'   => 'A túa conta usa agora o inicio de sesión con Kanka.',
        ],
        'title'             => 'Conta',
    ],
    'api'       => [
        'helper'    => 'Dámosche a benvida ás APIs de Kanka. Xera un token de acceso persoal para usar na túa solicitude API e reunir información das campañas das que es parte.',
        'link'      => 'Ler a documentación da API',
        'title'     => 'API',
    ],
    'apps'      => [
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
    'boost'     => [
        'benefits'      => [
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
            'third'             => 'Para potenciar unha campaña, vai á súa páxina e fai clic no botón :boost_button enriba do botón :edit_button.',
            'upload'            => 'Tamaño máximo de subida aumentado para toda persoa integrante da campaña.',
        ],
        'buttons'       => [
            'boost'         => 'Potenciar',
            'superboost'    => 'Superpotenciar',
            'tooltips'      => [
                'boost'         => 'Potenciar unha campaña usa :amount dos teus potenciadores',
                'superboost'    => 'Superpotenciar unha campaña usa :amount dos teus potenciadores',
            ],
        ],
        'campaigns'     => 'Campañas potenciadas :count / :max',
        'exceptions'    => [
            'already_boosted'       => 'A campaña ":name" xa está potenciada.',
            'exhausted_boosts'      => 'Non che quedan potenciadores. Elimina o teu potenciador dunha campaña antes de darllo a outra.',
            'exhausted_superboosts' => 'Non che quedan potenciadores. Precisas 3 potenciadores para superpotenciar unha campaña.',
        ],
        'success'       => [
            'boost'         => 'Campaña ":name" potenciada.',
            'delete'        => 'Quitouse o teu potenciador de ":name".',
            'superboost'    => 'Campaña ":name" superpotenciada.',
        ],
        'title'         => 'Potenciar',
        'unboost'       => [
            'description'   => 'Tes certeza de que queres deixar de potenciar a campaña ":tag"?',
            'title'         => 'Despotenciando unha campaña',
        ],
    ],
    'countries' => [
        'austria'       => 'Austria',
        'belgium'       => 'Bélxica',
        'france'        => 'Francia',
        'germany'       => 'Alemania',
        'italy'         => 'Italia',
        'netherlands'   => 'Países Baixos',
    ],
    'invoices'  => [
        'actions'   => [
            'download'  => 'Descargar PDF',
            'view_all'  => 'Ver todo',
        ],
        'fields'    => [
            'date'  => 'Data',
        ],
    ],
];
