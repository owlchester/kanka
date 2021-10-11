<?php

return [
    'campaign'          => [
        'application'   => [
            'approved'  => 'Ton application pour rejoindre la campagne :campaign a été approvée.',
            'new'       => 'Nouvelle application pour :campaign.',
            'rejected'  => 'Ton application pour rejoindre la campagne :campaign a été rejetée. Raison: :reason',
        ],
        'asset_export'  => 'Un export des images de la campagne est disponible. Ce liens sera disponible durant :time minutes.',
        'boost'         => [
            'add'           => 'La campagne :campaign est à présent boostée par :user.',
            'remove'        => ':user ne boost plus la campagne :campaign.',
            'superboost'    => 'La campagne :campaign est superboostée par :user.',
        ],
        'export'        => 'Un export de la campagne est disponible. Ce lien est disponible pendant :time minutes.',
        'export_error'  => 'Une erreur est survenue lors de l\'export de la campagne. Prière de nous contacter si ce problème persiste.',
        'join'          => ':user a rejoint la campagne :campaign.',
        'leave'         => ':user a quitté la campagne :campaign.',
        'plugin'        => [
            'deleted'   => 'Le plugin :plugin a été supprimé du marketplace et retiré de la campagne :campaign.',
        ],
        'role'          => [
            'add'       => 'Tu es maintenant membre du rôle :role de la campagne :campaign.',
            'remove'    => 'Tu ne fais plus partie du rôle :role de la campagne :campaign.',
        ],
    ],
    'clear'             => [
        'action'    => 'Tout supprimer',
        'confirm'   => 'Es-tu sûr de vouloir supprimer toutes les notifications? Cette action ne peut pas être annulée.',
        'success'   => 'Notifications supprimées.',
    ],
    'header'            => ':count notifications',
    'index'             => [
        'title' => 'Notifications',
    ],
    'no_notifications'  => 'Il n\'y a actuellement aucune notification.',
    'permissions'       => [],
    'subscriptions'     => [
        'charge_fail'   => 'Une erreur est survenue lors du paiement. Kanka va ressayer encore une fois. Si rien ne change, prière de nous contacter.',
        'deleted'       => 'Ta souscription à Kanka a été annulée après trop d\'essais ratés avec ta méthode de paiement. Va sur la page de ta souscription et mets à jour tes données de paiement.',
        'ended'         => 'Ta souscription a Kanka est terminée. Tes boosters de campagnes et rôles Discord ont été retirés. Nous espérons te revoir bientôt!',
        'failed'        => 'Problème lors du traitement de la méthode de paiement, merci de les mettre à jour.',
        'started'       => 'L\'abonnement à Kanka a commencé.',
    ],
    'unread'            => 'Nouvelle notification',
];
