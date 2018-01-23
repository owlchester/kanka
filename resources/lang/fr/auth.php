<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'Ces informations ne correspondent pas avec nos entrées.',
    'throttle' => 'Trop d\'essais. Veuillez réessayer dans :seconds secondes.',

    'login' => [
        'title' => 'Login',
        'remember_me' => 'Se souvenir de moi',
        'or' => 'OU',
        'submit' => 'Se connecter',

        'login_with_facebook' => 'Connexion avec Facebook',
        'login_with_google' => 'Connexion avec Google',
        'login_with_twitter' => 'Connexion avec Twitter',

        'password_forgotten' => 'Mot de passe oublié?',
        'new_account' => 'S\'enregistrer avec un nouveau compte',
        'fields' => [
            'email' => 'Adresse Email',
            'password' => 'Mot de passe',
        ]
    ],
    'register' => [
        'title' => 'Register',
        'fields' => [
            'email' => 'Adresse email',
            'name' => 'Votre nom d\'utilisateur',
            'password' => 'Mot de passe',
            'password_confirmation' => 'Confirmez votre mot de passe',
        ],
        'submit' => 'S\'enregistrer',

        'register_with_facebook' => 'S\'enregister avec Facebook',
        'register_with_google' => 'S\'enregister avec Google',
        'register_with_twitter' => 'S\'enregister avec Twitter',

        'already_account' => 'Vous avez déjà un compte',
        'errors' => [
            'email_already_taken' => 'Un compte avec cette adresse email est déjà enregistré.',
            'general_error' => 'Une erreure est survenue lors de la création du compte. Merci de ressayer.'
        ],
        'email' => [
            'title' => 'Bienvenue sur kanka.io!',
            'body' => '<p>Bienvenue sur kanka.io!</p>' .
                '<p>Ton compte a bien été créé avec cette adresse email.</p>',
            'login' => 'Se connecter',
        ]
    ],
    'reset' => [
        'title' => 'Réinitialisation du mot de passe',
        'send' => 'M\'envoyer un mail de réinitialisation de mot de passe',
        'submit' => 'Enregistrer',
        'fields' => [
            'email' => 'Adresse email',
            'password' => 'Mot de passe',
            'password_confirmation' => 'Confirmation du mot de passe',
        ]
    ]

];
