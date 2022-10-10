<?php

return [
    'communication' => [
        'description'   => 'Toutes les données de l\'utilisateur sont transportées de manière sûre et confidentielle, car elles sont cryptées en transit via SSL. Le cryptage des données en transit les protège contre l\'espionnage non autorisé, la modification et les attaques de type "man-in-the-middle".',
        'title'         => 'Communication sécurisée',
    ],
    'credit-card'   => [
        'description'   => 'Nous ne stockons pas les informations relatives aux cartes de crédit. Nous utilisons Stripe pour traiter les cartes de crédit, et toutes les communications entre les utilisateurs, nos serveurs et Stripe sont cryptées. Les seules informations relatives aux cartes de crédit fournies par Stripe que nous stockons sont la date d\'expiration et la marque de votre carte, afin que nous puissions avertir nos clients de l\'expiration de leur carte.',
        'title'         => 'Carte de crédit',
    ],
    'data-backup'   => [
        'description'   => 'Notre base de données est sauvegardée deux fois par jour pour garantir la sécurité et la haute disponibilité de tes données. Les sauvegardes de notre base de données sont régulièrement testées afin de garantir que nous pouvons rapidement restaurer les données si cela s\'avère nécessaire.',
        'title'         => 'Backups de données',
    ],
    'data-breach'   => [
        'description'   => 'Si Kanka devait être la cible d\'une violation de données et tes données personnelles compromises, nous signalerions rapidement les autorités locales ainsi que les utilisateurs concernés.',
        'title'         => 'Violation de données',
    ],
    'data-center'   => [
        'description'   => 'Kanka est hébergé sur plusieurs serveurs afin d\'assurer de la redondance, et nous avons mis en place des procédures de récupération en cas de sinistre. Nos serveurs sont hébergés par Hetzner.',
        'title'         => 'Sécurité du centre de données',
    ],
    'description'   => 'Notre petite équipe est déterminée de fournir une superbe protection de données pour s\'assurer que tes informations sont à l\'abris chez nous.',
    'infrastructure'=> [
        'description'   => 'Nos serveurs et toutes tes données sont hébergés sur des serveurs situés dans l\'Union Européenne. Cela nous permet de répondre à des exigences réglementaires et de conformité spécifiques qui garantissent que tes données sont en sécurité chez nous. Nos fournisseurs de centres de données, Hetzner et Amazon Cloud Europe, sont reconnu pour leur qualité et d\'expertise dans le traitement des données numériques.',
        'title'         => 'Infrastructure hébergée dans l\'UE',
    ],
    'logs'          => [
        'description'   => 'Nous recueillons automatiquement des journaux détaillés afin de pouvoir résoudre rapidement et efficacement les bugs et les problèmes des utilisateurs. Ces journaux détaillés sont fréquemment purgés, et sont également automatiquement purgés lorsque tu supprimes ton compte.',
        'title'         => 'Collection de logs',
    ],
    'title'         => 'La securité chez Kanka',
];
