<?php

return [
    'campaign'          => [
        'export'    => 'Un export de la campagne est disponnible. <a href=":link">Télécharger</a>. Ce lien sera disponnible durant 30 minutes.',
        'join'      => ':user a rejoind la campagne :campaign.',
        'leave'     => ':user a quitté la campagne :campaign.',
        'role'      => [
            'add'       => 'Tu es maintenant membre du rôle :role de la campagne :campaign.',
            'remove'    => 'Tu ne fait plus partie du rôle :role de la campagne :campaign.',
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
];
