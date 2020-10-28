<?php

return [
    'actions'           => [
        'follow'    => 'Suivre',
        'unfollow'  => 'Ne plus suivre',
    ],
    'campaigns'         => [
        'tabs'  => [
            'modules'   => ':count modules',
            'roles'     => ':count rôles',
            'users'     => ':count membres',
        ],
    ],
    'description'       => 'Place à la créativité',
    'helpers'           => [
        'follow'    => 'Suivre une campagne la rend visibile dans le changeur de campagne (en haut à droite) après tes campagnes.',
        'setup'     => 'Configurer le tableau de bord de la campagne',
    ],
    'latest_release'    => 'Dernière modification',
    'notifications'     => [
        'modal' => [
            'confirm'   => 'Compris',
            'title'     => 'Notification importante',
        ],
    ],
    'recent'            => [
        'title' => 'Modifications récentes sur les :name',
    ],
    'settings'          => [
        'title' => 'Paramètres du tableau de bord',
    ],
    'setup'             => [
        'actions'   => [
            'add'               => 'Ajouter un widget',
            'back_to_dashboard' => 'Retour au tableau de bord',
            'edit'              => 'Modifier un widget',
        ],
        'title'     => 'Configuration du tableau de bord de campagne',
        'widgets'   => [
            'calendar'      => 'Calendrier',
            'preview'       => 'Extrait d\'entité',
            'random'        => 'Entité au hasard',
            'recent'        => 'Récent',
            'unmentioned'   => 'Entités non-mentionnées',
        ],
    ],
    'title'             => 'Tableau de bord',
    'welcome'           => [],
    'widgets'           => [
        'calendar'      => [
            'actions'           => [
                'next'      => 'Changer la date au prochain jour',
                'previous'  => 'Changer la date au jour précédent',
            ],
            'events_today'      => 'Aujourd\'hui',
            'previous_events'   => 'Précédents',
            'upcoming_events'   => 'Prochainement',
        ],
        'create'        => [
            'success'   => 'Widget ajouté au tableau de bord.',
        ],
        'delete'        => [
            'success'   => 'Widget retiré du tableau de bord.',
        ],
        'fields'        => [
            'width' => 'Largeur',
        ],
        'recent'        => [
            'entity-header' => 'Utiliser l\'image d\'en-tête de l\'entité',
            'full'          => 'Entier',
            'help'          => 'Afficher seulement la dernière entité modifiée avec un aperçu de celle-ci.',
            'helpers'       => [
                'entity-header' => 'Si l\'entité à une image d\'en-tête (limité aux campagnes boostées), le widget utilisera cette image au lieu de l\'image principale de l\'entité.',
                'full'          => 'Afficher le contenu entier de l\'entité au lieu d\'un aperçu.',
            ],
            'singular'      => 'Singulier',
            'tags'          => 'Filtrer la liste des entités récemment modifiées sur une ou plusieurs étiquettes.',
            'title'         => 'Récemment modifié',
        ],
        'unmentioned'   => [
            'title' => 'Entité non mentionnées',
        ],
        'update'        => [
            'success'   => 'Widget modifié.',
        ],
        'widths'        => [
            '0' => 'Automatique',
            '12'=> 'Complet',
            '3' => 'Minuscule (25%)',
            '4' => 'Petit',
            '6' => 'Moitié',
            '8' => 'Large (66%)',
        ],
    ],
];
