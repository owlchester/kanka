<?php

return [
    'actions'   => [
        'download'  => 'Télécharger',
        'export'    => 'Exporter la campagne',
    ],
    'confirm'   => [
        'notification'  => 'Les membres du rôle :admin seront notifiés lorsque l\'export sera prêt à être téléchargé.',
        'title'         => 'Confirmation d\'export',
        'warning'       => 'Tu es sur le point d\'exporter les données de la campagne. Ce processus peut prendre beaucoup de temps selon la taille de la campagne. Tu peux continuer à utiliser Kanka pendant que nos serveurs génèrent l\'export.',
    ],
    'errors'    => [
        'limit' => 'La campagne a déjà été exportée une fois aujourd\'hui. Exporter la campagne sera possible de nouveau demain.',
    ],
    'expired'   => 'Liens expiré',
    'progress'  => 'Progrès',
    'size'      => 'Taille',
    'status'    => [
        'failed'    => 'Échoué',
        'finished'  => 'Terminé',
        'running'   => 'En cours',
        'scheduled' => 'Programmé',
    ],
    'success'   => 'L\'export de la campagne a été mis en file d\'attente pour traitement. Tous les membres du rôle :admin seront notifiés une fois que le fichier sera prêt à être téléchargé.',
    'title'     => 'Export',
];
