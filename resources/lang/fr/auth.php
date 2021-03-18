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

    'failed'    => 'Ces informations ne correspondent pas avec nos entrées.',
    'helpers'   => [
        'password'  => 'Afficher / Cacher le mot de passe',
    ],
    'login'     => [
        'fields'                => [
            'email'     => 'Adresse Email',
            'password'  => 'Mot de passe',
        ],
        'login_with_facebook'   => 'Connexion avec Facebook',
        'login_with_google'     => 'Connexion avec Google',
        'login_with_twitter'    => 'Connexion avec Twitter',
        'new_account'           => 'S\'enregistrer avec un nouveau compte',
        'or'                    => 'OU',
        'password_forgotten'    => 'Mot de passe oublié?',
        'remember_me'           => 'Se souvenir de moi',
        'submit'                => 'Se connecter',
        'title'                 => 'Login',
    ],
    'register'  => [
        'already_account'           => 'Tu as déjà un compte',
        'errors'                    => [
            'email_already_taken'   => 'Un compte avec cette adresse email est déjà enregistré.',
            'general_error'         => 'Une erreur est survenue lors de la création du compte. Merci de ressayer.',
        ],
        'fields'                    => [
            'email'     => 'Adresse email',
            'name'      => 'Votre nom d\'utilisateur',
            'password'  => 'Mot de passe',
            'tos'       => 'J\'accepte la <a href=":privacyUrl" target="_blank">Politique de confidentialité</a>.',
        ],
        'register_with_facebook'    => 'S\'enregister avec Facebook',
        'register_with_google'      => 'S\'enregister avec Google',
        'register_with_twitter'     => 'S\'enregister avec Twitter',
        'submit'                    => 'S\'inscrire',
        'title'                     => 'Inscription',
    ],
    'reset'     => [
        'fields'    => [
            'email'                 => 'Adresse email',
            'password'              => 'Mot de passe',
            'password_confirmation' => 'Confirmation du mot de passe',
        ],
        'send'      => 'M\'envoyer un mail de réinitialisation de mot de passe',
        'submit'    => 'Enregistrer',
        'title'     => 'Réinitialisation du mot de passe',
    ],
    'throttle'  => 'Trop d\'essais. Veuillez réessayer dans :seconds secondes.',
];
