<?php

return [
    'apps'              => [
        'discord'   => [
            'invalid'   => 'Ton jeton Discord a expiré. Prière de resynchroniser ton compte Discord et ton compte Kanka.',
        ],
    ],
    'campaign'          => [
        'application'       => [
            'approved'              => 'Ton application pour rejoindre la campagne :campaign a été approuvée.',
            'approved_message'      => 'Ton application pour rejoindre la campagne :campaign a été approuvée. Raison: :reason',
            'new'                   => 'Nouvelle application pour :campaign.',
            'rejected'              => 'Ton application pour rejoindre la campagne :campaign a été rejetée. Raison: :reason',
            'rejected_no_message'   => 'Ton application pour rejoindre la campagne :campaign a été rejetée.',
        ],
        'asset_export'      => 'Un export des images de la campagne est disponible. Ce liens sera disponible durant :time minutes.',
        'boost'             => [
            'add'           => 'La campagne :campaign est à présent boostée par :user.',
            'remove'        => ':user ne boost plus la campagne :campaign.',
            'superboost'    => 'La campagne :campaign est superboostée par :user.',
        ],
        'created'           => 'Tu as créé :campaign.',
        'deleted'           => 'La campagne :campaign a été supprimée.',
        'export'            => 'Un export de la campagne est disponible. Ce lien est disponible pendant :time minutes.',
        'export_error'      => 'Une erreur est survenue lors de l\'export de la campagne. Prière de nous contacter si ce problème persiste.',
        'hidden'            => 'La campagne :campaign est maintenant cachée de la page des campagnes publiques.',
        'import'            => [
            'failed'    => 'L\'import de la campagne :campaign a échoué.',
            'success'   => 'L\'import de la campagne :campaign est terminé.',
        ],
        'join'              => ':user a rejoint la campagne :campaign.',
        'leave'             => ':user a quitté la campagne :campaign.',
        'new_owner'         => 'Tu es devenu un admin de :campaign.',
        'plugin'            => [
            'deleted'   => 'Le plugin :plugin a été supprimé du marketplace et retiré de la campagne :campaign.',
        ],
        'premium'           => [
            'add'       => 'Les fonctionnalités Premium ont été débloquées pour la campagne :campaign par :user.',
            'remove'    => ':user ne débloque plus les fonctionnalités Premium pour la campagne :campaign.',
        ],
        'removed-image'     => 'L\'image ou l\'entête de :entity a été retirée dû à une plainte pour droit d\'auteur.',
        'role'              => [
            'add'       => 'Tu es maintenant membre du rôle :role de la campagne :campaign.',
            'remove'    => 'Tu ne fais plus partie du rôle :role de la campagne :campaign.',
        ],
        'troubleshooting'   => [
            'joined'    => 'Le membre de l\'équipe Kanka :user a rejoins la campagne :campaign.',
        ],
    ],
    'clear'             => [
        'action'    => 'Tout supprimer',
        'success'   => 'Notifications supprimées.',
        'title'     => 'Vider les notifications',
    ],
    'features'          => [
        'approved'  => 'Ton idée :feature a été acceptée.',
        'finished'  => 'Ton idée :feature est maintenant disponible dans Kanka!',
        'rejected'  => 'Ton idée :feature a été rejetée, raison: :reason.',
    ],
    'header'            => ':count notifications',
    'index'             => [
        'title' => 'Notifications',
    ],
    'map'               => [
        'chunked'   => 'La carte :name a fini d\'être traitée et est maintenant utilisable.',
    ],
    'no_notifications'  => 'Il n\'y a actuellement aucune notification.',
    'plugins'           => [
        'comments'  => [
            'new_comment'   => ':user a laissé un nouveau commentaire sur le plugin :plugin.',
            'new_reply'     => ':user a répondu à ton commentaire dans :plugin.',
        ],
    ],
    'subscriptions'     => [
        'charge_fail'   => 'Une erreur est survenue lors du paiement. Kanka va ressayer encore une fois. Si rien ne change, prière de nous contacter.',
        'deleted'       => 'Ton abonnement à Kanka a été annulé après trop d\'essais ratés avec ta méthode de paiement. Va sur la page d\'abonnement et mets à jour tes données de paiement.',
        'ended'         => 'Ton abonnement a Kanka est terminée. Tes campagnes premium et rôles Discord ont été retirés. Nous espérons te revoir bientôt!',
        'failed'        => 'Problème lors du traitement de la méthode de paiement, merci de les mettre à jour.',
        'started'       => 'L\'abonnement à Kanka a commencé.',
        'trial'         => 'Ton essai gratuit de Kanka est terminé. Nous espérons que tu l\'as apprécié et nous espérons te revoir bientôt!',
    ],
    'unread'            => 'Nouvelle notification',
];
