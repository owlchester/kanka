<?php

return [
    'actions'   => [
        'add'   => 'Ajouter une nouvelle image par défaut',
    ],
    'create'    => [
        'error'     => 'Problème lors de la sauvegarde. Est-ce que :type est déjà créé?',
        'success'   => 'Image par défaut pour :type créée.',
        'title'     => 'Nouvelle image par défaut',
    ],
    'destroy'   => [
        'success'   => 'Image par défaut pour :type retirée.',
    ],
    'helper'    => 'Gestion des images d\'entité par défaut pour la campagne. Celles-ci seront affichées dans les listes, mais pas sur l\'entité même.',
    'index'     => [
        'title' => 'Images d\'entité par défaut',
    ],
    'title'     => 'Campagne :campaign Images d\'entité par défaut',
];
