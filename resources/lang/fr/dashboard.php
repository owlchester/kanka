<?php

return [
    'actions'           => [
        'follow'    => 'Suivre',
        'unfollow'  => 'Ne plus suivre',
    ],
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
    'welcome'           => [
        'body'      => <<<'TEXT'
Bienvenue sur Kanka! Ta première campagne a été créée et nous avons inclus quelques examples d'entités pour t'inspirer (tu peux les supprimer à tout moment).

Tu voudras probablement commencer par ajouter tes propres entités. Choisi une catégorie sur le menu à gauche pour commencer. Les catégories dont tu n'as pas besoin peuvent être disactivées dans la configuration de la campagne. Désactiver une catégorie la retire du menu.

Voici quelques conseils pour t'aider à commencer:
- Tu peux écrire @nom dans la description d'une entité pour lier vers d'autres entités. Le lien sera automatiquement mis à jour en cas de modifications de l'entité mentionnée.
- Tu peux configurer ton profile pour changer de thème ou le nombre d'entité affiché par page. L'accès à la configuration du profile se fait en cliquant en haut à droite. 
- Il y a des tutoriaux sur :youtube. Les tutoriaux couvrent la thématique des attributs ou comment partager la campagne avec tes amis. La :faq peut aussi t'être utile.
- Si tu as des questions, suggestions ou simplement envie de discuter, rejoins-nous sur :discord
TEXT
,
        'header'    => 'Bienvenue',
    ],
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
        'fields'    => [
            'width' => 'Largeur',
        ],
        'recent'    => [
            'full'      => 'Entier',
            'help'      => 'Afficher seulement la dernière entité modifiée avec un aperçu de celle-ci.',
            'helpers'   => [
                'full'  => 'Afficher le contenu entier de l\'entité au lieu d\'un aperçu.',
            ],
            'singular'  => 'Singulier',
            'title'     => 'Récemment modifié',
        ],
        'update'    => [
            'success'   => 'Widget modifié.',
        ],
        'widths'    => [
            '0' => 'Automatique',
            '12'=> 'Complet',
            '4' => 'Petit',
            '6' => 'Moitié',
        ],
    ],
];
