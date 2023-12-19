<?php

return [
    'actions'       => [
        'import'    => 'Envoyer l\'export',
    ],
    'description'   => 'Importer les entités, les notes, les attributs, la galerie et d\'autres éléments d\'une exportation de campagne dans cette campagne. Cela se produit dans le backend et peut prendre un certain temps, alors profites d\'un café. Tu et les autres administrateurs de campagne serez informés lorsque le processus d\'importation sera terminé.',
    'fields'        => [
        'file'      => 'Fichier ZIP de l\'export',
        'updated'   => 'Dernière modification',
    ],
    'limitation'    => 'Uniquement les fichiers zip sont permi. Max :size.',
    'status'        => [
        'failed'    => 'Echoué',
        'finished'  => 'Terminé',
        'queued'    => 'Programmé',
        'running'   => 'En cours',
    ],
    'title'         => 'Import',
];
