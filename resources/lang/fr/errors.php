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
            '2' => 'Un rapport avec l\'erreur rencontrée nous a été envoyé, mais quelques fois ça aide si nous avons plus de détails.',
        ],
        'title' => 'Erreur',
    ],
    '503'       => [
        'body'  => [
            '1' => 'Kanka est actuellement en maintenance, ce qui d\'habitude signifie qu\'une mise à jour est en cours!',
            '2' => 'Désolé pour le dérangement. Tout reviendra à la normale dans quelques minutes.',
        ],
        'title' => 'Maintenance',
    ],
    '503-form'  => [
        'body'  => 'Problème lors de le l\'enregistrement des données, ce qui est généralement causé par l\'un des deux scénarii suivant. Prière d\'ouvrir Kanka dans une :link. Si l\'application est en maintenance, il est préférable de sauvegarder les données dans une autre application et de réssayer lorsque Kanka est de retour. Si le message "Checking your browser" apparait, la sauvegarde peut être essayée à nouveau.',
        'link'  => 'nouvelle fenêtre',
        'title' => 'Erreure inattendue.',
    ],
    'footer'    => 'Si tu as besoin d\'aide, contactes-nous a hello@kanka.io ou sur le :discord.',
];
