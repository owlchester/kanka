<?php

return [
    'campaigns'         => [
        'manage'    => 'Gérer la campagne',
        'tabs'      => [
            'modules'   => ':count modules',
            'roles'     => ':count rôles',
            'users'     => ':count membres',
        ],
    ],
    'description'       => 'Place à la créativité',
    'helpers'           => [
        'setup' => 'Configurer le tableau de bord de la campagne',
    ],
    'latest_release'    => 'Dernière modification',
    'notifications'     => [
        'modal' => [
            'confirm'   => 'Compris',
            'title'     => 'Notification importante',
        ],
    ],
    'recent'            => [
        'add'           => 'Nouveau :name',
        'no_entries'    => 'Aucun élément de ce type pour l\'instant.',
        'title'         => 'Modifications récentes sur les :name',
        'view'          => 'Tous les :name',
    ],
    'settings'          => [
        'description'   => 'Personnalisation du tableau de bord',
        'edit'          => [
            'success'   => 'Paramètres modifiés.',
        ],
        'fields'        => [
            'helper'        => 'Il est possible changer le comportement du tableau de bord. Cela concerne toutes les campagnes dont le compte est membre.',
            'recent_count'  => 'Nombre d\'élément récents',
        ],
        'title'         => 'Paramètre du tableau de bord',
    ],
    'setup'             => [
        'actions'   => [
            'add'               => 'Ajouter un widget',
            'back_to_dashboard' => 'Retour au tableau de bord',
            'edit'              => 'Modifier un widget',
        ],
        'title'     => 'Configuration du tableau de bord de campagne',
        'widgets'   => [
            'calendar'  => 'Calendrier',
            'preview'   => 'Extrait d\'entité',
            'recent'    => 'Récent',
        ],
    ],
    'title'             => 'Tableau de bord',
    'widgets'           => [
        'calendar'  => [
            'actions'           => [
                'next'      => 'Changer la date au prochain jour',
                'previous'  => 'Changer la date au jour précédent',
            ],
            'events_today'      => 'Aujourd\'hui',
            'previous_events'   => 'Précédents',
            'upcoming_events'   => 'Prochainement',
        ],
        'create'    => [
            'success'   => 'Widget ajouté au tableau de bord.',
        ],
        'delete'    => [
            'success'   => 'Widget retiré du tableau de bord.',
        ],
        'recent'    => [
            'title' => 'Récemment modifié',
        ],
        'update'    => [
            'success'   => 'Widget modifié.',
        ],
    ],
];
