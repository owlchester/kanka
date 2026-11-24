<?php

return [
    '403'               => [
        'body'  => 'Tu n\'as pas accès à cette page!',
        'title' => 'Accès refusé.',
    ],
    '403-form'          => [
        'help'  => 'Ceci peut être dû à la session qui n\'est plus active. Prière de se reconnecter dans une autre fenêtre avant de ressayer d\'enregistrer.',
    ],
    '404'               => [
        'body'  => 'Désolé, la page demandée ne peut être trouvée.',
        'title' => 'Page Inconnue',
    ],
    '500'               => [
        'body'  => [
            '1' => 'Oups, quelque chose s\'est mal passé.',
            '2' => 'Un rapport avec l\'erreur rencontrée nous a été envoyé, mais quelques fois ça aide si nous avons plus de détails.',
        ],
        'title' => 'Erreur',
    ],
    '503'               => [
        'body'  => [
            '1' => 'Kanka est actuellement en maintenance, ce qui d\'habitude signifie qu\'une mise à jour est en cours!',
            '2' => 'Désolé pour le dérangement. Tout reviendra à la normale dans quelques minutes.',
        ],
        'json'  => 'Kanka est actuellement en maintenance. Prière de ressayer dans quelques minutes.',
        'title' => 'Maintenance',
    ],
    'back-to-campaigns' => 'Revenir à une de tes campagnes',
    'entity-visibility' => [
        'comparison'    => 'Réglages de la permission «Voir» par rôle de campagne',
        'direct'        => 'Réglage direct de la permission «Voir» pour :member: :setting',
        'entity-view'   => 'Permission «Voir» sur cette entrée',
        'membership'    => 'Rôle de :member',
        'module-view'   => 'Permission «Voir» sur :module',
        'reasons'       => [
            'direct-deny'   => 'La permission «Voir» est explicitement refusée à :member pour cette entrée.',
            'no-grant'      => ':member ne bénéficie d’aucune permission «Voir» pour la catégorie ou cette entrée.',
            'private'       => 'Cette entrée est privée. Seuls les admins peuvent la voir. Les réglages ci-dessous ne modifient pas cette restriction.',
            'role-deny'     => 'Les rôles suivants refusent la permission «Voir» sur cette entrée:',
        ],
        'role'          => 'Rôle',
        'settings'      => [
            'allow'         => 'Permettre',
            'assigned'      => 'Attribué',
            'automatic'     => 'Automatique (admin)',
            'deny'          => 'Refuser',
            'fallback'      => 'Appliqué par défaut',
            'granted'       => 'Accordée',
            'inherit'       => 'Hériter',
            'not-granted'   => 'Non accordée',
            'unassigned'    => 'Non attribué',
        ],
        'title'         => 'Pourquoi :member ne peut pas voir cette entrée?',
    ],
    'footer'            => 'Si tu as besoin d\'aide, contacte-nous a hello@kanka.io ou sur le :discord.',
    'log-in'            => 'La connexion à ton compte pourrait te permettre de trouver ce que tu cherches.',
    'post_layout'       => 'Mise en page d\'article invalide.',
    'private-campaign'  => [
        'auth'  => [
            'helper'    => 'Tu n\'as pas accès à cette campagne.',
        ],
        'guest' => [
            'helper'    => 'La campagne que tu essaye d\'accéder est privée et tu n\'es pas connecté à ton compte.',
            'login'     => 'Se connecter pourrait te donner accès au contenu.',
        ],
        'title' => 'Campagne privée',
    ],
];
