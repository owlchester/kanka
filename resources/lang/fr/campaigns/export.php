<?php

return [
    'actions'   => [
        'export'    => 'Exporter les données de la campagne',
    ],
    'errors'    => [
        'limit' => 'La campagne a déjà été exportée une fois aujourd\'hui. Exporter la campagne sera possible de nouveau demain.',
    ],
    'helpers'   => [
        'import'    => 'Ces exports ne peuvent pas être réimportés et sont destinés à ta tranquillité d\'esprit ou si tu  ne comptes plus utiliser Kanka. Pour une expérience d\'exportation et d\'importation plus robuste, il est recommandé de consulter l\':api.',
        'intro'     => 'Une campagne peut être exportée une fois par jour par les administrateurs de la campagne. Cela génère deux fichiers zip dans l\'arrière plan. Le premier fichier zip contient toutes les entités de la campagne, tandis que le second fichier zip contient toutes les images. Tu recevras une notification dans Kanka dès que les fichiers zip seront prêts à être téléchargés.',
        'json'      => 'Le contenu de la campagne est exporté au format JSON. Ce format est basé sur du texte, et peut être ouvert dans un éditeur de texte ou dans le naviguateur.',
    ],
    'success'   => 'La campagne est en train d\'être exportée. Tu receveras une notification dans Kanka dès que l\'export est prêt à être téléchargé.',
    'title'     => 'Export de campagne',
];
