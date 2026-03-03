<?php

return [
    'actions'   => [
        'boost_name'    => 'Booster :name',
    ],
    'available' => 'Boosters disponibles :amount/:total',
    'benefits'  => [
        'boosted'       => 'Booster une campagne avec :one booster débloque l\'accès au :marketplace, les options de thèmages, des téléchargements plus grand pour tous les membres de la campagne, récupérer des entrées supprimées, et :more.',
        'more'          => 'd\'autres fonctionnalités incroyables.',
        'superboosted'  => 'Superbooster une campagne avec :amount boosters débloque tous les bénéfices d\'une campagne boostée, en plus de la galerie de campagne, des logs complètes de changements aux entrées, et :more.',
    ],
    'boost'     => [
        'actions'   => [
            'confirm'   => 'Booste-la!',
            'remove'    => 'Ne plus booster :campaign',
            'subscribe' => 'S\'abonner à Kanka',
            'upgrade'   => 'Mettre à niveau ton abonnement',
        ],
        'confirm'   => 'Wouah! Tu es sur le point de booster :campaign. Ceci assignera un (:cost) de tes boosters de campagne.',
        'duration'  => 'Les boosters assignés restent assignés jusqu\'à ce que tu les retires manuellement, ou quand ton abonnement prend fin.',
        'errors'    => [
            'boosted'           => 'Oups, on dirait que :campaign est déjà boosté!',
            'out-of-boosters'   => 'Oh non! Tu n\'as pas assez de boosters disponible. Tu as :available est a besoin de :cost. Tu peux soit arrêter de booster une autre campagne, ou :upgrade.',
        ],
        'pitch'     => 'Abonne-toi pour accéder aux boosters de campagne.',
        'success'   => 'La campagne :campaign est maintenant boostée. Régale-toi avec les incroyables fonctionnalités!',
        'title'     => 'Booster :campaign',
        'upgrade'   => 's\'abonner à un niveau plus élevé',
    ],
    'campaign'  => [
        'boosted'       => 'Boosté par :user depuis :time',
        'premium'       => 'Premium grace à :user depuis :time',
        'standard'      => 'Standard',
        'superboosted'  => 'Superboosté par :user depuis :time',
        'unboosted'     => 'Non-boostée',
    ],
    'intro'     => [
        'anyone'    => 'Tu n\'es pas limité à seulement booster des campagnes que tu as créé. Tu peux booster n\'importe quelle campagne dont tu es membre ou que tu peux voir. Cela inclus les campagnes où tu es un joueur, ou une :public que tu apprécies.',
        'data'      => 'Quand une campagne n\'est plus boostée, l\'accès aux fonctionnalités boostées est retiré. Par contre, aucune information est supprimée, du coups booster la campagne à nouveau dans le future restaure l\'accès aux données.',
        'first'     => 'Les fonctionnalités avancées sont déverrouillées en affectant tes boosters pour booster ou superbooster une campagne. Le nombre de boosters dont tu disposes est déterminé par ton abonnement. Ce numéro est à votre disposition à tout moment tant que tu es et restes abonné. Booster une campagne assignera l\'un de tes boosters, tandis que superbooster une campagne en assignera trois.',
    ],
    'pitch'     => [
        'benefits'      => [
            'backup'        => 'Récupérer des entrées supprimées pendant :amount jours',
            'customisable'  => 'Contrôle créatif complet de la campagne',
            'entities'      => 'Meilleur contrôle de comment les entrées se comportent et s\'affichent',
            'icons'         => 'Accès à des milliers d\'icônes pour les cartes et chronologies.',
            'relations'     => 'Explorer les relations d\'une entrée visuellement',
            'title'         => 'Les campagnes boostées ont',
            'upload'        => 'Taille de fichier plus grand pour tous les membres de la campagne',
        ],
        'description'   => 'Assignes des boosters aux campagnes et aides à débloquer des fonctionnalités incroyables pour tous les membres de la campagne. Pas impressionné par les campagnes boostées? Nous avons ce qu\'il te faut avec des campagnes superboostées!',
        'more'          => 'Jettes un coup d\'oeil sur la liste complète des fonctionnalités sur la page :boosters.',
        'title'         => 'Accèdes au niveau supérieur avec la personnalisation et des avantages pour tous les membres de la campagne.',
    ],
    'ready'     => [
        'available'         => 'Tes boosters disponibles.',
        'pricing'           => 'Tous les niveaux d\'abonnement contiennent au moins un booster de campagne et commencent à :amount par mois.',
        'pricing-amount'    => ':currency:amount',
        'title'             => 'Booster une campagne',
    ],
    'superboost'=> [
        'actions'   => [
            'confirm'   => 'Superbooste-la!',
            'instead'   => 'Superbooste-la pour :count!',
            'remove'    => 'Ne plus superbooster :campaign',
        ],
        'confirm'   => 'Oooh! Tu es le point de booster :campagne. Cela attribuera trois (:cost) de tes boosters de campagne disponibles.',
        'errors'    => [
            'boosted'   => 'Oups, on dirait que :campaign est déjà superboostée!',
        ],
        'success'   => 'La campagne :campaign est maintenant superboostée. Régale-toi avec les nouvelles fonctionnalités!',
        'title'     => 'Superbooster :campaign',
        'upgrade'   => 'Prêts pour l\'ultime expérience Kanka? Superbooster :campaign assignera :cost boosters de campagne supplémentaires.',
    ],
    'title'     => 'Boosters de campagne',
    'unboost'   => [
        'confirm'   => 'Oui, je suis sûr',
        'status'    => [
            'boosting'      => 'booster',
            'superboosting' => 'superbooster',
        ],
        'success'   => 'La campagne :campaign n\'est plus boostée, et tes boosters sont à nouveau disponibles.',
        'title'     => 'Ne plus booster une campagne',
        'warning'   => 'Es-tu sûr de vouloir arrêter :action :campaign? Cela libérera tes boosters assignés et masquera tout le contenu et les fonctionnalités liés aux avantages jusqu\'à ce que la campagne soit à nouveau boostée.',
    ],
];
