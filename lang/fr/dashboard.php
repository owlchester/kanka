<?php

return [
    'actions'       => [
        'customise' => 'Personnaliser le tableau de bord',
        'follow'    => 'Suivre',
        'join'      => 'Joindre',
        'unfollow'  => 'Ne plus suivre',
    ],
    'dashboards'    => [
        'actions'       => [
            'edit'  => 'Modifier',
            'new'   => 'Nouveau',
        ],
        'create'        => [
            'helper'    => 'Crée un nouveau tableau de bord pour :name, et attribue les rôles qui peuvent le voir ou l\'avoir comme tableau de bord par défaut.',
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
        'pitch'         => 'Crées plusieurs tableaux de bord avec des permissions pour chaque rôle de la campagne.',
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
    'helpers'       => [
        'follow'    => 'Suivre une campagne la rend visibile dans le changeur de campagne (en haut à droite) après tes campagnes.',
        'join'      => 'Cette campagne est ouverte à de nouveaux membres. Cliquer pour postuler pour rejoindre.',
    ],
    'setup'         => [
        'actions'   => [
            'add'               => 'Ajouter un widget',
            'back_to_dashboard' => 'Retour au tableau de bord',
            'edit'              => 'Modifier un widget',
            'new'               => 'Nouveau widget :type',
        ],
        'reorder'   => [
            'helper'    => 'Fais-moi glisser pour me déplacer',
            'success'   => 'Widgets réordonnés.',
        ],
        'title'     => 'Configuration du tableau de bord de campagne',
        'tutorial'  => [
            'blog'  => 'notre tutoriel',
            'text'  => 'Besoin d\'aide avec la mise en place du tableau de bord de la campagne? Tu peux lire :blog pour de l\'aide et inspiration.',
        ],
    ],
    'title'         => 'Tableau de bord',
    'widgets'       => [
        'advanced_options_boosted'  => 'Activer plus d\'options comme afficher les épingles avec une :boosted_campaign.',
        'calendar'                  => [
            'actions'           => [
                'next'      => 'Changer la date au prochain jour',
                'previous'  => 'Changer la date au jour précédent',
            ],
            'previous_events'   => 'Précédents',
            'upcoming_events'   => 'Prochainement',
        ],
        'campaign'                  => [
            'helper'    => 'Ce widget affiche l\'entête de campagne. Ce widget est tout le temps visible sur le tableau de bord de défaut.',
        ],
        'create'                    => [
            'helper'            => 'Sélectionne un type de widget à ajouter au tableau de bord :name.',
            'helper-default'    => 'Sélectionne un type de widget à ajouter au tableau de bord par défaut.',
            'success'           => 'Widget ajouté au tableau de bord.',
            'title'             => 'Nouveau widget',
        ],
        'delete'                    => [
            'success'   => 'Widget retiré du tableau de bord.',
        ],
        'fields'                    => [
            'class'             => 'Classe CSS',
            'dashboard'         => 'Tableau de bord',
            'name'              => 'Nom de widget personnalisé',
            'optional-entity'   => 'Liens vers une entrée',
            'order'             => 'Ordre d\'affichage',
            'size'              => 'Taille',
            'width'             => 'Largeur',
        ],
        'helpers'                   => [
            'class'     => 'Définition d\'une classe css ajoutée au widget.',
            'filters'   => 'Cliquer pour en savoir plus sur les options de filtrage.',
        ],
        'orders'                    => [
            'name_asc'  => 'Nom ascendant',
            'name_desc' => 'Nom descendant',
            'oldest'    => 'Anciennement modifié',
            'recent'    => 'Récemment modifié',
        ],
        'preview'                   => [
            'displays'  => [
                'expand'    => 'Entrée extensible',
                'full'      => 'Entrée complète',
            ],
            'fields'    => [
                'display'   => 'Affichage',
            ],
        ],
        'random'                    => [
            'helpers'   => [
                'name'  => 'Le nom de l\'entrée au hasard peut être référencé avec {name}',
            ],
            'type'      => [
                'all'   => 'Tous',
            ],
        ],
        'recent'                    => [
            'advanced_filter'   => 'Filtre avancé',
            'advanced_filters'  => [
                'mentionless'   => 'Sans mention (entrées qui ne mentionnent pas d\'autres entrées)',
                'unmentioned'   => 'Non mentionné (entrées qui ne sont pas mentionnées par d\'autres entrées)',
            ],
            'all-entities'      => 'Toutes les entrées',
            'entity-header'     => 'Utiliser l\'image d\'en-tête de l\'entrée',
            'filters'           => 'Filtres',
            'help'              => 'Afficher seulement la dernière entrée modifiée avec un aperçu de celle-ci.',
            'helpers'           => [
                'entity-header'     => 'Si l\'entrée à une image d\'en-tête (limité aux campagnes boostées), le widget utilisera cette image au lieu de l\'image principale de l\'entrée.',
                'show_attributes'   => 'Afficher les propriétés épinglées de l\'entrée.',
                'show_members'      => 'Si l\'entrée est une famille ou organisation, afficher les membres sous l\'entrée.',
                'show_relations'    => 'Afficher les relations épinglées de l\'entrée.',
            ],
            'show_attributes'   => 'Afficher les propriétés épinglées',
            'show_members'      => 'Afficher les membres',
            'show_relations'    => 'Afficher les relations épinglées',
            'singular'          => 'Singulier',
            'tags'              => 'Filtrer la liste des entrées récemment modifiées sur une ou plusieurs étiquettes.',
            'title'             => 'Récemment modifié',
        ],
        'tabs'                      => [
            'advanced'  => 'Avancé',
            'setup'     => 'Général',
        ],
        'unmentioned'               => [
            'title' => 'Entrée non mentionnées',
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
