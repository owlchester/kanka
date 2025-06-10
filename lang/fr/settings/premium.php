<?php

return [
    'actions'       => [
        'remove'    => 'Retirer Premium',
        'unlock'    => 'Débloquer Premium',
    ],
    'create'        => [
        'actions'   => [
            'confirm'   => 'Débloquer Premium!',
        ],
        'confirm'   => 'Waouw! Tu es sur le point de débloquer des fonctionnalités premium pour :campaign. Cette campagne utilisera l\'une de tes campagnes Premium disponibles.',
        'duration'  => 'Les campagnes Premium le restent jusqu\'à ce qu\'elles soient supprimées manuellement ou que ton abonnement prenne fin.',
        'pitch'     => 'Abonne-toi pour débloquer des campagnes Premium.',
        'success'   => 'La campagne :campaign est maintenant Premium. Éclate-toi avec les chouettes fonctionnalités!',
    ],
    'exceptions'    => [
        'already'       => 'Les fonctionnalités Premium ont déjà été débloquées pour cette campagne.',
        'out-of-stock'  => 'Tu n\'as pas assez de campagnes Premium disponibles pour débloquer cette campagne. Supprime le statut Premium d\'une autre campagne ou :upgrade.',
    ],
    'pitch'         => [
        'description'   => 'Passes au niveau supérieur pour les campagnes et débloques des fonctionnalités incroyables pour tous les membres.',
        'more'          => 'Consultes la liste complète des avantages sur notre page :premium.',
        'title'         => 'Les campagnes Premium reçoivent',
    ],
    'ready'         => [
        'available'         => 'Tes campagnes Premium disponnibles.',
        'pricing'           => 'Tous nos abonnements contiennent au moins une campagne Premium et commence à :amount par mois.',
        'pricing-amount'    => ':currency:amount',
        'title'             => 'Débloquer Premium',
    ],
    'remove'        => [
        'confirm'   => 'Ouais, je suis sûr',
        'cooldown'  => 'Les fonctionnalités premiums pour :campaign peuvent être retirées après :date.',
        'success'   => 'Les fonctionnalités premium ont été désactivée de la campagne :campaign. Tu peux maintenant débloquer les fonctionnalités Premium dans une autre campagne.',
        'title'     => 'Désactiver les fonctionnalités Premium',
        'warning'   => 'Es-tu sûr de vouloir désactivé les fonctionnalités Premium de :campaign? Cela te permettra de débloquer une autre campagne. Rien ne sera supprimé, tout le contenu et toutes les fonctionnalités liés aux avantages seront cachées jusqu\'à ce que le statut Premium de la campagne soit réactivé.',
    ],
];
