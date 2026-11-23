<?php

return [
    'actions'       => [
        'status'    => 'Status: :status',
    ],
    'create'        => [
        'helper'    => 'Créer un nouveau rôle pour la campagne.',
    ],
    'overview'      => [
        'limited'   => ':amount de :total rôles créés.',
        'title'     => 'Rôles disponibles',
        'unlimited' => ':amount de rôles illimités créés.',
    ],
    'permissions'   => [
        'campaign-features' => 'Fonctionnalités de campagne',
        'content-modules'   => 'Contenu de catégories',
        'toggle'            => [
            'action'    => 'Tout cocher',
            'tooltip'   => 'Cocher la permission :action pour toutes les catégorie.',
        ],
    ],
    'public'        => [
        'actions'               => [
            'disable_all'   => 'Tout désactiver',
            'enable_all'    => 'Tout activer',
        ],
        'disabled_categories'   => [
            'helper'    => 'Ces catégories sont actuellement désactivées dans les paramètres de ta campagne. Les modifications de l’accès public que tu fais ici prendront effet si tu les réactives.',
            'title'     => 'Catégories désactivées (:count)',
        ],
        'helpers'               => [
            'click'     => 'Clique sur n\'importe quelle catégorie pour activer ou désactiver l\'accès public à toutes les entrées qu\'elle contient',
            'intro'     => 'Contrôle ce que les non-membres peuvent voir dans la campagne',
            'main'      => 'Sélectionne quelles catégories sont visibles pour toute personne qui consulte la campagne, qu\'elle soit connectée ou non. Ça inclut les visiteurs publics et les utilisateurs de Kanka qui ne sont pas membres de la campagne',
            'preview'   => 'Aperçu en tant que non-membre',
        ],
        'private_notice'        => [
            'action'    => 'Modifier la visibilité',
            'body'      => 'Les non-membres ne peuvent rien consulter pour le moment. Tes modifications prendront effet quand tu régleras la visibilité de la campagne sur «Publique (pas répertoriée)» ou «Publique».',
            'title'     => 'Cette campagne est actuellement privée.',
        ],
        'status'                => [
            'hidden'    => 'Masqué pour les visiteurs',
            'visible'   => 'Visible pour les visiteurs',
        ],
        'summary'               => 'Catégories visibles: :visible sur :total',
        'toggle_all'            => [
            'disabled'  => 'Toutes les catégories sont désormais masquées pour :role.',
            'enabled'   => 'Toutes les catégories actives sont désormais visibles pour :role.',
        ],
    ],
    'show'          => [
        'title' => 'Permissions :role - :campaign',
    ],
    'standard'      => [
        'advanced'  => [
            'toggle'    => 'Afficher les permissions une par une',
        ],
        'features'  => [
            'groups'    => [
                'bookmarks' => 'Favoris',
                'campaign'  => 'Campagne',
                'gallery'   => 'Galerie',
                'templates' => 'Archétypes et modèles',
            ],
            'helpers'   => [
                'bookmarks'         => 'Permet de gérer les favoris de la campagne.',
                'template_articles' => 'Permet de gérer les modèles d’articles.',
                'template_entries'  => 'Permet de gérer les archétypes et les modèles d’entrées.',
            ],
        ],
        'presets'   => [
            'clear_all' => 'Tout décocher',
            'contribute'=> 'Contribuer',
            'custom'    => 'Personnalisé',
            'full'      => 'Accès complet',
            'label'     => 'Réglages rapides',
            'none'      => 'Aucun accès',
            'view'      => 'Lecture seule',
        ],
        'save_bar'  => [
            'reset'     => 'Réinitialiser',
            'unsaved'   => 'Tu as des modifications de permissions non enregistrées.',
        ],
    ],
    'toggle'        => [
        'disabled'  => 'Les membre du rôle :role ne peuvent plus :action les :entities.',
        'enabled'   => 'Les membre du rôle :role peuvent maintenant :action les :entities.',
    ],
    'warnings'      => [
        'adding-to-admin'   => 'Les membres du rôle :name ont accès à tous les éléments de la campagne, et ne peuvent pas être retiré par d\'autres membres du rôle. Après :amount minutes, seules le/la membre peut se retirer du rôle.',
    ],
];
