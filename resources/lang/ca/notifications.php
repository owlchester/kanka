<?php

return [
    'campaign'          => [
        'application'           => [
            'approved'  => 'S\'ha aprovat la vostra sol·licitud per unir-vos a la campanya :campaign.',
            'new'       => 'Nova sol·licitud per a :campaign',
            'rejected'  => 'S\'ha rebutjat la vostra sol·licitud per unir-vos a la campanya :campaign. Motiu:',
        ],
        'asset_export'          => 'Ja està disponible una exportació de la campanya. L\'enllaç estarà disponible durant :time minuts.',
        'asset_export_error'    => 'Hi ha hagut un error al exportar els arxius de la campanya. Això pot passar a les campanyes de gran tamany.',
        'boost'                 => [
            'add'           => ':user està millorant la campanya :campaign.',
            'remove'        => ':user ja no està millorant la campanya :campaign.',
            'superboost'    => ':user està supermillorant la campanya :campaign.',
        ],
        'deleted'               => 'S\'ha eliminat la campanya :campaign.',
        'export'                => 'Ja s\'ha exportat la campanya. L\'enllaç estarà disponible durant :time minuts.',
        'export_error'          => 'Hi ha hagut un error mentre s\'exportava la campanya. Contacteu-nos si l\'error persisteix.',
        'join'                  => ':user s\'ha unit a la campanya :campaign.',
        'leave'                 => ':user ha abandonat la campanya :campaign.',
        'plugin'                => [
            'deleted'   => 'El plugin :plugin s\'ha eliminat del mercat i s\'ha retirat de la vostra campanya :campaign.',
        ],
        'role'                  => [
            'add'       => 'Us han assignat el rol :role a la campanya :campaign.',
            'remove'    => 'Us han tret el rol :role a la campanya :campaign.',
        ],
        'troubleshooting'       => [
            'joined'    => 'L\'integrant de l\'equip de Kanka :user s\'ha unit a la campanya :campaign.',
        ],
    ],
    'clear'             => [
        'action'    => 'Neteja-ho tot',
        'confirm'   => 'Segur que voleu eliminar totes les notificacions? Aquesta acció no es pot desfer.',
        'success'   => 'S\'han eliminat les notificacions.',
    ],
    'header'            => 'Teniu :count notificacions',
    'index'             => [
        'title' => 'Notificacions',
    ],
    'no_notifications'  => 'No teniu cap notificació.',
    'subscriptions'     => [
        'charge_fail'   => 'Hi ha hagut un error processant el pagament. Si us plau, espereu un moment mentre tornem a intentar-ho. Si no es produeixen canvis, contacteu amb nosaltres.',
        'deleted'       => 'La vostra subscripció a Kanka s\'ha cancelat degut a massa intents fallits de fer el càrrec a la targeta. Dirigiu-vos a la configuració de la subscripció i proveu d\'actualitzar les vostres dades de pagament.',
        'ended'         => 'La vostra subscripció a Kanka ha finalitzat. S\'han eliminat les millores de campanya i els vostres rols de Discord. Esperem tornar-vos a veure aviat!',
        'failed'        => 'No hem pogut carregar les vostres dades de pagament. Si us plau, actualitzeu-les a la configuració del pagament.',
        'started'       => 'La vostra subscripció a Kanka ha començat.',
    ],
    'unread'            => 'Nova notificació',
];
