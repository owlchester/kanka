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
        'content-modules'   => 'Contenu de modules',
        'toggle'            => [
            'action'    => 'Tout cocher',
            'tooltip'   => 'Cocher la permission :action pour tous les modules.',
        ],
    ],
    'public'        => [
        'campaign'      => [
            'private'   => 'La campagne est actuellement privée.',
            'public'    => 'La campagne est actuellement publique.',
        ],
        'description'   => 'Définis les autorisations pour le rôle public afin de visualiser les entités suivantes de la campagne. Un utilisateur est automatiquement dans le rôle public s\'il accède la campagne sans en être un membre.',
        'helpers'       => [
            'click'     => 'Clique sur n\'importe quel module pour activer ou désactiver l\'accès public à toutes les entités qu\'il contient',
            'intro'     => 'Contrôle ce que les non-membres peuvent voir dans la campagne',
            'main'      => 'Sélectionne quels modules sont visibles pour toute personne qui consulte la campagne, qu\'elle soit connectée ou non. Ça inclut les visiteurs publics et les utilisateurs de Kanka qui ne sont pas membres de la campagne',
            'preview'   => 'Aperçu en tant que non-membre',
        ],
        'test'          => 'Pour tester les permissions du rôle public, ouvres l\'url de la campagne :url dans une fenêtre incognito.',
    ],
    'show'          => [
        'title' => 'Permissions :role - :campaign',
    ],
    'toggle'        => [
        'disabled'  => 'Les membre du rôle :role ne peuvent plus :action les :entities.',
        'enabled'   => 'Les membre du rôle :role peuvent maintenant :action les :entities.',
    ],
    'warnings'      => [
        'adding-to-admin'   => 'Les membres du rôle :name ont accès à tous les éléments de la campagne, et ne peuvent pas être retiré par d\'autres membres du rôle. Après :amount minutes, seules le/la membre peut se retirer du rôle.',
    ],
];
