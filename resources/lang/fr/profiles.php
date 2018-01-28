<?php

return [
    'description'   => 'Modification du profil',
    'edit'          => [
        'success'   => 'Profil modifié',
    ],
    'fields'        => [
        'avatar'                    => 'Avatar',
        'email'                     => 'Email',
        'name'                      => 'Nom',
        'new_password'              => 'Nouveau mot de passe (optional)',
        'new_password_confirmation' => 'Confirmation du nouveau mot de passe',
        'newsletter'                => 'Je souhaite être contacté par email de temps en temps.',
        'password'                  => 'Mot de passe actuel',
    ],
    'password'      => [
        'success'   => 'Mot de passe modifié.',
    ],
    'placeholders'  => [
        'email'                     => 'Adresse email',
        'name'                      => 'Nom tel qu\'affiché',
        'new_password'              => 'Nouveau mot de passe',
        'new_password_confirmation' => 'Confirmation du nouveau mot de passe',
        'password'                  => 'Saisie du mot de passe actuel',
    ],
    'sections'      => [
        'delete'    => [
            'delete'    => 'Supprimer mon compte',
            'title'     => 'Suppression du compte',
            'warning'   => 'Toutes les données relatives au compte seront supprimée. Êtes-vous certain?',
        ],
        'password'  => [
            'title' => 'Modification du mot de passe',
        ],
    ],
    'title'         => 'Profil',
];
