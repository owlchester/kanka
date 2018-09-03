<?php

return [
    '403'       => [
        'body'  => 'Tu n\'as pas accès à cette page!',
        'title' => 'Accès refusé.',
    ],
    '404'       => [
        'body'  => 'Désolé, la page demandée ne peut être trouvée.',
        'title' => 'Page Inconnue',
    ],
    '500'       => [
        'body'  => [
            '1' => 'Oups, quelque chose s\'est mal passé.',
            '2' => 'Un rapport avec l\'erreur rencontrée nous a été envoyée, mais quelques fois ça aide si nous avons plus de détails.',
        ],
        'title' => 'Erreure',
    ],
    '503'       => [
        'body'  => [
            '1' => 'Kanka est actuellement en maintenance, ce qui d\'habitude signifie qu\'une mise à jour est en cours!',
            '2' => 'Désolé pour le dérangement. Tout reviendra à la normale dans quelques minutes.',
        ],
        'title' => 'Maintenance',
    ],
    'footer'    => 'Si tu as besoin d\'aide, contactes-nous a hello@kanka.io ou sur le :discord.',
];
