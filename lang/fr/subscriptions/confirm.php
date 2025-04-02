<?php

return [
    'actions'   => [
        'pay'       => 'Payer :currency:amount maintenant',
        'paypal'    => 'Payer :currency:amount avec PayPal',
    ],
    'helpers'   => [
        'auto-renew'    => [
            'monthly'   => 'Ton abonnement est renouvelé automatiquement chaque mois. Ta prochaine date de facturation est au :date.',
            'none'      => 'Le paiement par PayPal est un paiement unique et ne se renouvelle pas automatiquement. Tu pourras te réabonner une fois que ton abonnement prend fin après le :date.',
            'yearly'    => 'Ton abonnement est renouvelé automatiquement tous les 12 mois. Ta prochaine date de facturation est au :date.',
        ],
        'paypal'        => 'Tu seras redirigé vers PayPal pour effectuer cette transaction.',
        'refund'        => 'Nous offrons une politique de remboursement de 14 jours pour tous les abonnements annuels. Il te suffit de nous envoyer un courriel à l\'adresse :email pour entamer une procédure de remboursement.',
    ],
    'title'     => 'Abonnement :name',
];
