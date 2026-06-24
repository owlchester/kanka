<?php

return [
    'actions'   => [
        'pay'       => 'Payer :currency:amount maintenant',
        'subscribe' => 'S’abonner pour :currency:amount',
    ],
    'helpers'   => [
        'auto-renew'    => [
            'monthly'   => 'Ton abonnement est renouvelé automatiquement chaque mois. Ta prochaine date de facturation est au :date.',
            'yearly'    => 'Ton abonnement est renouvelé automatiquement tous les 12 mois. Ta prochaine date de facturation est au :date.',
        ],
        'refund'        => 'Nous offrons une politique de remboursement de 14 jours pour tous les abonnements annuels. Il te suffit de nous envoyer un courriel à l\'adresse :email pour entamer une procédure de remboursement.',
        'tiny'          => 'Merci de soutenir une petite équipe de worldbuilders passionnés.',
    ],
    'title'     => 'Abonnement :name',
];
