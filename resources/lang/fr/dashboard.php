<?php

return [
    'actions'           => [
        'follow'    => 'Suivre',
        'join'      => 'Joindre',
        'unfollow'  => 'Ne plus suivre',
    ],
    'campaigns'         => [
        'tabs'  => [
            'modules'   => ':count modules',
            'roles'     => ':count rôles',
            'users'     => ':count membres',
        ],
    ],
    'dashboards'        => [
        'actions'       => [
            'edit'      => 'Modifier',
            'new'       => 'Nouveau',
            'switch'    => 'Basculer vers',
        ],
        'boosted'       => 'Les :boosted_campaigns peuvent créer des tableaux de bords supplémentaires pour chaque rôle.',
        'create'        => [
            'success'   => 'Nouveau tableau de bord :name créé.',
            'title'     => 'Nouveau tableau de bord',
        ],
        'custom'        => [
            'text'  => 'Modification du tableau de bord :name de la campagne.',
        ],
        'default'       => [
            'text'  => 'Modification du tableau de bord par défaut de la campagne.',
            'title' => 'Tableau de bord par défaut',
        ],
        'delete'        => [
            'success'   => 'Tableau de bord :name supprimé.',
        ],
        'fields'        => [
            'copy_widgets'  => 'Copier les widgets',
            'name'          => 'Nom du tableau de bord',
            'visibility'    => 'Visibilité',
        ],
        'helpers'       => [
            'copy_widgets'  => 'Dupliquer les widgets depuis :name vers ce nouveau tableau de bord.',
        ],
        'placeholders'  => [
            'name'  => 'Nom du tableau de bord',
        ],
        'update'        => [
            'success'   => 'Tableau de bord :name modifié.',
            'title'     => 'Modifier le tableau de bord :name',
        ],
        'visibility'    => [
            'default'   => 'Défaut',
            'none'      => 'Aucune',
            'visible'   => 'Visible',
        ],
    ],
    'helpers'           => [
        'follow'    => 'Suivre une campagne la rend visibile dans le changeur de campagne (en haut à droite) après tes campagnes.',
        'join'      => 'Cette campagne est ouverte à de nouveaux membres. Cliquer pour postuler pour rejoindre.',
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
        'tutorial'  => [
            'blog'  => 'notre tutoriel',
            'text'  => 'Besoin d\'aide avec la mise en place du tableau de bord de la campagne? Tu peux lire :blog pour de l\'aide et inspiration.',
        ],
        'widgets'   => [
            'calendar'      => 'Calendrier',
            'campaign'      => 'Entête de campagne',
            'header'        => 'Entête',
            'preview'       => 'Extrait d\'entité',
            'random'        => 'Entité au hasard',
            'recent'        => 'Récent',
            'unmentioned'   => 'Entités non-mentionnées',
        ],
    ],
    'title'             => 'Tableau de bord',
    'welcome'           => [],
    'widgets'           => [
        'actions'                   => [
            'advanced-options'  => 'Options avancées',
            'delete-confirm'    => 'ce widget',
        ],
        'advanced_options_boosted'  => 'Les :boosted_campaigns ont des options avancées tel que pouvoir afficher les enfants d\'une famille ou les attributs d\'une entité sur le tableau de bord.',
        'calendar'                  => [
            'actions'           => [
                'next'      => 'Changer la date au prochain jour',
                'previous'  => 'Changer la date au jour précédent',
            ],
            'events_today'      => 'Aujourd\'hui',
            'previous_events'   => 'Précédents',
            'upcoming_events'   => 'Prochainement',
        ],
        'campaign'                  => [
            'helper'    => 'Ce widget affiche l\'entête de campagne. Ce widget est tout le temps visible sur le tableau de bord de défaut.',
        ],
        'create'                    => [
            'success'   => 'Widget ajouté au tableau de bord.',
        ],
        'delete'                    => [
            'success'   => 'Widget retiré du tableau de bord.',
        ],
        'fields'                    => [
            'class'             => 'Classe CSS',
            'dashboard'         => 'Tableau de bord',
            'name'              => 'Nom de widget personnalisé',
            'optional-entity'   => 'Liens vers une entité',
            'order'             => 'Ordre d\'affichage',
            'text'              => 'Texte',
            'width'             => 'Largeur',
        ],
        'helpers'                   => [
            'class' => 'Définition d\'une classe css ajoutée au widget.',
        ],
        'orders'                    => [
            'name_asc'  => 'Nom ascendant',
            'name_desc' => 'Nom descendant',
            'recent'    => 'Récemment modifié',
        ],
        'random'                    => [
            'helpers'   => [
                'name'  => 'Le nom de l\'entité au hasard peut être référencé avec {name}',
            ],
        ],
        'recent'                    => [
            'advanced_filter'   => 'Filtre avancé',
            'advanced_filters'  => [
                'mentionless'   => 'Sans mention (entités qui ne mentionnent pas d\'autres entités)',
                'unmentioned'   => 'Non mentionné (entités qui ne sont pas mentionnées par d\'autres entités)',
            ],
            'entity-header'     => 'Utiliser l\'image d\'en-tête de l\'entité',
            'filters'           => 'Filtres',
            'full'              => 'Entier',
            'help'              => 'Afficher seulement la dernière entité modifiée avec un aperçu de celle-ci.',
            'helpers'           => [
                'entity-header'     => 'Si l\'entité à une image d\'en-tête (limité aux campagnes boostées), le widget utilisera cette image au lieu de l\'image principale de l\'entité.',
                'filters'           => 'Les entités affichées peuvent être filtrées. En savoir plus en lisant la page d\'aide :link.',
                'full'              => 'Afficher le contenu entier de l\'entité au lieu d\'un aperçu.',
                'show_attributes'   => 'Afficher les attributs épinglés de l\'entité.',
                'show_members'      => 'Si l\'entité est une famille ou organisation, afficher les membres sous l\'entrée.',
                'show_relations'    => 'Afficher les relations épinglées de l\'entité.',
            ],
            'show_attributes'   => 'Afficher les attributs épinglés',
            'show_members'      => 'Afficher les membres',
            'show_relations'    => 'Afficher les relations épinglées',
            'singular'          => 'Singulier',
            'tags'              => 'Filtrer la liste des entités récemment modifiées sur une ou plusieurs étiquettes.',
            'title'             => 'Récemment modifié',
        ],
        'tabs'                      => [
            'advanced'  => 'Avancé',
            'setup'     => 'Général',
        ],
        'unmentioned'               => [
            'title' => 'Entité non mentionnées',
        ],
        'update'                    => [
            'success'   => 'Widget modifié.',
        ],
        'widths'                    => [
            '0' => 'Automatique',
            '12'=> 'Complet (100%)',
            '3' => 'Minuscule (25%)',
            '4' => 'Petit (33%)',
            '6' => 'Moitié (50%)',
            '8' => 'Grand (66%)',
            '9' => 'Large (75%)',
        ],
    ],
];
