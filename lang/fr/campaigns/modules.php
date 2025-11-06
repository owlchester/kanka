<?php

return [
    'actions'       => [
        'create'    => 'Créer un module',
        'customise' => 'Personnaliser',
    ],
    'create'        => [
        'helper'    => 'Créer un nouveau module personnalisé pour organiser des entités qui n\'entrent pas dans les autres modules.',
        'success'   => 'Nouveau module créé.',
        'title'     => 'Nouveau module',
    ],
    'delete'        => [
        'confirm'   => 'Saisir :code pour confirmer la suppression permanente du module personnalisé :name.',
        'helper'    => 'Es-tu sûr de vouloir supprimer le module :name? Ceci supprimera de manière permanente toutes les entités, favoris, et widgets lié à ce module.',
        'success'   => 'Module :name supprimé.',
        'title'     => 'Suppression de module',
    ],
    'errors'        => [
        'disabled'              => 'Le module :name est désactivé. :fix',
        'limit'                 => 'Il n\'est actuellement que possible de créer :max modules personnalités pendant qu\'on termine de construire cette nouvelle fonctionnalité.',
        'limit-title'           => 'Limite des modules personnalisés atteinte.',
        'subscription-limit'    => 'La campagne a atteint le nombre maximal de modules personnalisés disponibles. La personne qui débloque les fonctionnalités premium peut souscrire à un abonnement supérieur pour augmenter cette limite.',
    ],
    'fields'        => [
        'icon'          => 'Icône du module',
        'plural'        => 'Nom au pluriel du module',
        'singular'      => 'Nom au singulier du module',
        'update_name'   => 'Renommer le favori avec le nouveau nom du module',
    ],
    'helpers'       => [
        'custom'    => 'Ceci est un module personnalisé.',
        'icon'      => 'L\'icône :fontawesome, par example :example.',
        'info'      => 'Une campagne est composée de plusieurs modules qui interagissent entre eux. Il est possible d\'activer ou de désactiver les modules qui ne sont pas utiles pour la campagne. Désactiver un module ne supprime aucune de ses données, mais cache simplement l\'information.',
        'plural'    => 'Le pluriel des entités de du module. Par example, potions.',
        'roles'     => 'Sélection de rôle qui ont la permission de voir les entités de ce nouveau module. Ceci peut être modifié plus tard dans les permissions des rôles.',
        'singular'  => 'Le singulier d\'une entité de ce nouveau module. Par example, potion.',
    ],
    'pitch'         => 'Renommer et changer l\'icône associée à ce module pour l\'ensemble de la campagne.',
    'pitch-custom'  => 'Créer des modules personnalisés pour organiser des entités uniques.',
    'rename'        => [
        'helper'    => 'Modifier le nom et l\'icône du module tout au long de la campagne. Laisser vide pour utiliser le nom par défaut de Kanka.',
        'success'   => 'Module personnalisé.',
        'title'     => 'Personnaliser le module :module',
    ],
    'reset'         => [
        'default'   => 'Ceci réinitialisera que les modules par défaut, pas les modules personnalisés.',
        'success'   => 'Les modules de la campagne ont été réinitialisé.',
        'title'     => 'Réinitialiser des noms et icônes personnalisés des modules',
        'warning'   => 'Es-tu ous sûr de vouloir rétablir les noms et icônes d\'origine des modules de la campagne=',
    ],
    'sections'      => [
        'custom'        => 'Modules personnalisés',
        'default'       => 'Modules par défaut',
        'early-access'  => 'Accès anticipé',
        'features'      => 'Fonctionnalités',
    ],
    'states'        => [
        'disable'   => 'Désactiver',
        'enable'    => 'Activer',
    ],
];
