<?php

return [
    'actions'       => [
        'create'    => 'Créer une catégorie',
        'customise' => 'Personnaliser',
    ],
    'create'        => [
        'helper'    => 'Créer une nouvelle catégorie personnalisée pour organiser des entrées qui n\'entrent pas dans les autres catégories.',
        'success'   => 'Nouvelle catégorie créée.',
        'title'     => 'Nouvelle catégorie',
    ],
    'delete'        => [
        'confirm'           => 'Saisir :code pour confirmer la suppression permanente de la catégorie personnalisée :name.',
        'confirm-button'    => '{0} Supprimer définitivement :name|{1} Supprimer définitivement :name et :count entrée|[2,] Supprimer définitivement :name et :count entrées',
        'entities'          => '{1} Ceci supprimera définitivement :count entrée.|[2,] Ceci supprimera définitivement :count entrées.',
        'helper'            => 'Es-tu sûr de vouloir supprimer la catégorie :name? Ceci supprimera de manière permanente toutes les entrées, favoris, et widgets lié à celle-ci.',
        'success'           => 'Catégorie :name supprimée.',
        'title'             => 'Suppression de catégorie',
    ],
    'errors'        => [
        'disabled'              => 'La catégorie :name est désactivé. :fix',
        'empty-custom'          => 'Ajoute des catégories personnalisées pour organiser les données qui ne rentrent pas dans ceux par défaut.',
        'limit'                 => 'Il n\'est actuellement que possible de créer :max catégories personnalitées pendant qu\'on termine de construire cette nouvelle fonctionnalité.',
        'limit-title'           => 'Limite des catégories personnalisées atteinte.',
        'subscription-limit'    => 'Tu a atteint le nombre maximal de catégories personnalisées disponibles. La personne qui débloque les fonctionnalités premium peut souscrire à un abonnement supérieur pour augmenter cette limite.',
    ],
    'fields'        => [
        'icon'          => 'Icône de la catégorie',
        'image'         => 'Image de remplacement',
        'plural'        => 'Nom au pluriel de la catégorie',
        'singular'      => 'Nom au singulier de la catégorie',
        'status'        => 'Status de la catégorie',
        'update_name'   => 'Renommer le favori avec le nouveau nom de la catégorie',
    ],
    'helpers'       => [
        'custom'    => 'Ceci est une catégorie personnalisée.',
        'icon'      => 'L\'icône :fontawesome, par example :example.',
        'plural'    => 'Le pluriel des entrées de de la catégorie. Par example, potions.',
        'roles'     => 'Sélection de rôle qui ont la permission de voir les entrées de cette nouvelle catégorie. Ceci peut être modifié plus tard dans les permissions des rôles.',
        'singular'  => 'Le singulier d\'une entrée de cette nouvelle catégorie. Par example, potion.',
        'status'    => 'Les catégories désactivées sont cachées de la navigation et des menus. Aucune donnée n\'est supprimée.',
        'tutorial'  => 'Les catégories contrôlent quelles fonctionnalités sont visibles dans la campagne. Active celles que tu utilises et masque les autres. Désactiver une catégorie ne supprime jamais de données; ça les enlève juste de la navigation et des menus de création',
    ],
    'pitch'         => 'Renommer et changer l\'icône associée à cette catégorie pour l\'ensemble de la campagne.',
    'pitch-custom'  => 'Créer des catégories personnalisées pour organiser des entrées uniques.',
    'pitch-title'   => 'Débloque les catégories personnalisées',
    'rename'        => [
        'helper'    => 'Modifier le nom et l\'icône de la catégorie tout au long de la campagne. Laisser vide pour utiliser le nom par défaut de Kanka.',
        'success'   => 'Catégorie personnalisée.',
        'title'     => 'Personnaliser la catégorie :module',
    ],
    'reset'         => [
        'default'   => 'Ceci réinitialisera que les catégories par défaut, pas les catégorie personnalisées.',
        'success'   => 'Les catégories ont été réinitialisé.',
        'title'     => 'Réinitialiser des noms et icônes personnalisés des catégories',
        'warning'   => 'Es-tu ous sûr de vouloir rétablir les noms et icônes d\'origine des catégorie?',
    ],
    'sections'      => [
        'custom'        => 'Catégories personnalisées',
        'default'       => 'Catégories par défaut',
        'early-access'  => 'Accès anticipé',
        'features'      => 'Fonctionnalités',
    ],
    'states'        => [
        'disable'   => 'Désactiver',
        'disabled'  => 'La catégorie est désactivée',
        'enable'    => 'Activer',
        'enabled'   => 'La catégorie est activée',
    ],
    'status'        => [
        'enabled'   => 'Catégorie activée',
    ],
];
