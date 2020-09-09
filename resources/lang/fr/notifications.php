<?php

return [
    'campaign'          => [
        'boost'         => [
            'add'           => 'La campagne :campaign est à présent boostée par :user.',
            'remove'        => ':user ne boost plus la campagne :campaign.',
            'superboost'    => 'La campagne :campaign est superboostée par :user.',
        ],
        'export'        => 'Un export de la campagne est disponible. <a href=":link">Télécharger</a>. Ce lien sera disponible durant 30 minutes.',
        'export_error'  => 'Une erreur est survenue lors de l\'export de la campagne. Prière de nous contacter si ce problème persiste.',
        'join'          => ':user a rejoint la campagne :campaign.',
        'leave'         => ':user a quitté la campagne :campaign.',
        'role'          => [
            'add'       => 'Tu es maintenant membre du rôle :role de la campagne :campaign.',
            'remove'    => 'Tu ne fais plus partie du rôle :role de la campagne :campaign.',
        ],
    ],
    'header'            => ':count notifications',
    'index'             => [
        'description'   => 'Les dernières notifications.',
        'title'         => 'Notifications',
    ],
    'no_notifications'  => 'Il n\'y a actuellement aucune notification.',
    'permissions'       => [
        'body'  => 'Nous voulons te prévenir que nous avons complètement changé le système de permission pour chaque campagne.</p><p>Les campagnes peuvent maintenant avoir des rôles, et chaque rôle peut avoir les droits de lire, modifier ou supprimer des éléments. Chaque élément peut aussi être modifié avec des permissions individuelles. Ceci veut dire que Virginie et Maurice peuvent modifier leur personnage!</p><p>Le seul problème, c\'est que chaque campagne avec plusieurs utilisateurs doit maintenant définir les nouveaux rôles et permissions. Si tu es un Admin d\'une campagne, tu peux faire ça dans la gestion de la campagne. Si tu es membre d\'une campagne, tu ne peux rien voir jusqu\'à ce que l\'administrateurr s\'occupe des droits.',
        'title' => 'Permissions',
    ],
    'subscriptions'     => [
        'charge_fail'   => 'Une erreur est survenue lors du paiement. Kanka va ressayer encore une fois. Si rien ne change, prière de nous contacter.',
        'deleted'       => 'Ta souscription à Kanka a été annulée après trop d\'essais ratés avec ta méthode de paiement. Va sur la page de ta souscription et mets à jour tes données de paiement.',
        'ended'         => 'Ta souscription a Kanka est terminée. Tes boosters de campagnes et rôles Discord ont été retirés. Nous espérons te revoir bientôt!',
        'failed'        => 'Problème lors du traitement de la méthode de paiement, merci de les mettre à jour.',
        'started'       => 'L\'abonnement à Kanka a commencé.',
    ],
];
