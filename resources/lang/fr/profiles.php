<?php

return [
    'title' => 'Profil',
    'description' => 'Modification du profil',

    'edit' => [
        'success' => 'Profil modifié',
    ],

    'fields' => [
        'name' => 'Nom',
        'email' => 'Email',
        'new_password' => 'Nouveau mot de passe (optional)',
        'new_password_confirmation' => 'Confirmation du nouveau mot de passe',
        'password' => 'Mot de passe actuel',
        'avatar' => 'Avatar',
        'newsletter' => 'Je souhaite être contacté par email de temps en temps.',
    ],
    'placeholders' => [
        'name' => 'Nom tel qu\'affiché',
        'email' => 'Adresse email',
        'new_password' => 'Nouveau mot de passe',
        'new_password_confirmation' => 'Confirmation du nouveau mot de passe',
        'password' => 'Saisie du mot de passe actuel'
    ],
    'sections' => [
        'password' => [
            'title' => 'Modification du mot de passe',
        ],
        'delete' => [
            'title' => 'Suppression du compte',
            'warning' => 'Toutes les données relatives au compte seront supprimée. Êtes-vous certain?',
            'delete' => 'Supprimer mon compte',
        ]
    ],
    'password' => [
        'success' => 'Mot de passe modifié.',
    ]
];
