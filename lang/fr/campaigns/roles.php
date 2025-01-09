<?php

return [
    'actions'   => [
        'status'    => 'Status: :status',
    ],
    'overview'  => [
        'limited'   => ':amount de :total rôles créés.',
        'title'     => 'Rôles disponibles',
        'unlimited' => ':amount de rôles illimités créés.',
    ],
    'public'    => [
        'campaign'      => [
            'private'   => 'La campagne est actuellement privée.',
            'public'    => 'La campagne est actuellement publique.',
        ],
        'description'   => 'Définis les autorisations pour le rôle public afin de visualiser les entités suivantes de la campagne. Un utilisateur est automatiquement dans le rôle public s\'il accède la campagne sans en être un membre.',
        'test'          => 'Pour tester les permissions du rôle public, ouvres l\'url de la campagne :url dans une fenêtre incognito.',
    ],
    'show'      => [
        'title' => 'Permissions :role - :campaign',
    ],
    'toggle'    => [
        'disabled'  => 'Les membre du rôle :role ne peuvent plus :action les :entities.',
        'enabled'   => 'Les membre du rôle :role peuvent maintenant :action les :entities.',
    ],
    'warnings'  => [
        'adding-to-admin'   => 'Les membres du rôle :name ont accès à tous les éléments de la campagne, et ne peuvent pas être retiré par d\'autres membres du rôle. Après :amount minutes, seules le/la membre peut se retirer du rôle.',
    ],
];
