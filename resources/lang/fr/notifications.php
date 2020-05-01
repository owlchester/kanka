<?php

return [
    'campaign'          => [
        'boost'         => [
            'add'       => 'La campagne :campaign est à présent boostée par :user.',
            'remove'    => ':user ne boost plus la campagne :campaign.',
        ],
        'export'        => 'Un export de la campagne est disponnible. <a href=":link">Télécharger</a>. Ce lien sera disponnible durant 30 minutes.',
        'export_error'  => 'Une erreure est survenue lors de l\'export de la campagne. Prière de nous contacter si ce problème persiste.',
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
        'body'  => 'Nous voulons te prévenir que nous avons complètement changé le système de permission pour chaque campagne.</p><p>Les campagnes peuvent maintenant avoir des rôles, et chaque rôle peut avoir les droits de lire, modifier ou supprimer des éléments. Chaque élément peut aussi être modifié avec des permissions individuelles. Ceci veut dire que Virginie et Maurice peuvent modifier leur personnage!</p><p>Le seul problème, c\'est que chaque campagne avec plusieurs utilisateurs doit maintenant définir les nouveaux rôles et permissions. Si tu es un Admin d\'une campagne, tu peux faire ça dans la gestion de la campagne. Si tu es membre d\'une campagne, tu ne peux rien voir jusqu\'à ce que l\'administrator s\'occupe des droits.',
        'title' => 'Permissions',
    ],
    'subscriptions'     => [
        'ended' => 'Ta souscription à Kanka est terminée. Tes boosters de campagnes et des rôles Discord ont été retirés. Nous espérons te revoir bientôt!',
        'failed'=> 'Ta souscription à Kanka a été annulée après trop d\'échecs de transation. Vas sur la page de ta souscription et mets à jour tes données de paiement.',
    ],
];
