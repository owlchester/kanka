<?php

return [
    'dashboard' => [
        'actions'   => [
            'dismiss'   => 'Compris, merci',
            'start'     => 'Faire une visite guidée',
        ],
        'body'      => 'Nous avons repensé Kanka pour offrir une interface plus épurée et moins encombrée, qui te laisse te concentrer sur la création de tes univers. Certains boutons de navigation ont changé de place. Cette visite guidée te montre où les retrouver.',
        'steps'     => [
            'campaigns'     => [
                'body_desktop'  => 'Clique sur le nom de ta campagne en haut de la barre latérale (ou sur l’icône de l’univers lorsque la barre est réduite) pour changer de campagne ou en créer une.',
                'body_mobile'   => 'Ouvre l’onglet Compte en bas de l’écran pour passer d’une campagne à l’autre ou en créer une.',
                'title'         => 'Sélecteur de campagne',
            ],
            'profile'       => [
                'body_desktop'  => 'Ton compte, tes paramètres et tes notifications se trouvent ici. Clique sur ton nom ou ton avatar pour ouvrir le menu.',
                'body_mobile'   => 'Ton compte, tes paramètres et tes notifications se trouvent dans l’onglet Compte, en bas de l’écran.',
                'title'         => 'Ton profil et tes notifications',
            ],
            'search_create' => [
                'body_desktop'              => 'Trouve n’importe quoi avec la recherche (appuie sur K) ou utilise le bouton + (appuie sur N) pour créer rapidement une entrée depuis n’importe où.',
                'body_desktop_search_only'  => 'Trouve n’importe quoi dans cette campagne avec la recherche (appuie sur K).',
                'body_mobile'               => 'Utilise la recherche pour trouver ce que tu cherches dans ta campagne, ou touche Créer pour ajouter rapidement une entrée.',
                'body_mobile_search_only'   => 'Utilise la recherche en bas de l’écran pour trouver n’importe quoi dans cette campagne.',
                'title'                     => 'Recherche et création rapide',
                'title_search_only'         => 'Rechercher dans ta campagne',
            ],
        ],
        'title'     => 'Bienvenue sur Kanka v4',
        'tour'      => [
            'back'      => 'Retour',
            'done'      => 'Terminé',
            'next'      => 'Suivant',
            'skip'      => 'Passer la visite guidée',
            'step_of'   => 'Étape :current sur :total',
        ],
    ],
    'entry_form'=> [
        'actions'   => [
            'dismiss'   => 'Non merci',
            'try'       => 'Essayer',
        ],
        'body'      => 'Nous avons créé une interface plus épurée, pensée pour l’écriture, afin de créer et de modifier des entrées. Envie de l’essayer? Tu pourras revenir à tout moment à l’ancienne interface dans tes paramètres d’apparence.',
        'title'     => 'Essayer la nouvelle interface de l’éditeur d’entrées',
    ],
];
