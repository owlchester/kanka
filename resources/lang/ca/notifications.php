<?php

return [
    'campaign'          => [
        'boost'         => [
            'add'           => ':user està millorant la campanya :campaign.',
            'remove'        => ':user ja no està millorant la campanya :campaign.',
            'superboost'    => ':user està supermillorant la campanya :campaign.',
        ],
        'export'        => 'Ja s\'ha exportat la campanya. Per a descarregar-la, cliqueu <a href=":link">aquí</a>. L\'enllaç estarà disponible durant :time minuts.',
        'export_error'  => 'Hi ha hagut un error mentre s\'exportava la campanya. Contacteu-nos si l\'error persisteix.',
        'join'          => ':user s\'ha unit a la campanya :campaign.',
        'leave'         => ':user ha abandonat la campanya :campaign.',
        'role'          => [
            'add'       => 'Us han assignat el rol :role a la campanya :campaign.',
            'remove'    => 'Us han tret el rol :role a la campanya :campaign.',
        ],
    ],
    'header'            => 'Teniu :count notificacions',
    'index'             => [
        'description'   => 'Notificacions recents',
        'title'         => 'Notificacions',
    ],
    'no_notifications'  => 'No teniu cap notificació.',
    'permissions'       => [
        'body'  => 'Hem canviat completament el sistema de permisos a les campanyes!</p><p>Ara les campanyes poden tenir rols, i cada rol pot tenir permisos d\'accés, edició o eliminació d\'entitats. A més, cada entitat pot ser afinada amb permisos específics d\'usuari, així que la Júlia i el Sergi ara poden editar els seus propis personatges!</p><p>L\'únic desavantatge és que les campanyes amb diversos usuaris hauran de configurar els seus nous permisos. Si sou l\'administrador d\'una campanya, podeu fer-ho des de la pàgina d\'administració de la campanya. Si formeu part d\'una campanya, no veureu res fins que el propietari l\'hagi configurat.',
        'title' => 'Canvis als permisos',
    ],
    'subscriptions'     => [
        'charge_fail'   => 'Hi ha hagut un error processant el pagament. Si us plau, espereu un moment mentre tornem a intentar-ho. Si no es produeixen canvis, contacteu amb nosaltres.',
        'deleted'       => 'La vostra subscripció a Kanka s\'ha cancelat degut a massa intents fallits de fer el càrrec a la targeta. Dirigiu-vos a la configuració de la subscripció i proveu d\'actualitzar les vostres dades de pagament.',
        'ended'         => 'La vostra subscripció a Kanka ha finalitzat. S\'han eliminat les millores de campanya i els vostres rols de Discord. Esperem tornar-vos a veure aviat!',
        'failed'        => 'No hem pogut carregar les vostres dades de pagament. Si us plau, actualitzeu-les a la configuració del pagament.',
        'started'       => 'La vostra subscripció a Kanka ha començat.',
    ],
];
