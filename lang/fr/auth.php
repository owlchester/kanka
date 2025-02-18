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

    'banned'    => [
        'permanent' => 'Ton compte a été désactivé.',
        'temporary' => '{1} Ton compte a été suspendu pour :days jour.|[2,*] Ton compte a été suspendu pour :days jours.',
    ],
    'confirm'   => [
        'confirm'   => 'Confirmer',
        'error'     => 'Mot de passe invalid, merci de ressayer.',
        'helper'    => 'Confirmer le mot de passe avant de pouvoir continuer.',
        'title'     => 'Confirmation du mot de passe.',
    ],
    'continue'  => [
        'facebook'  => 'Continuer avec Facebook',
        'google'    => 'Continuer avec Google',
        'x'         => 'Continuer avec X',
    ],
    'failed'    => 'Ces informations ne correspondent pas avec nos données.',
    'helpers'   => [
        'password'  => 'Afficher / Cacher le mot de passe',
    ],
    'login'     => [
        'fields'                => [
            '2fa'       => 'Code à usage unique',
            'email'     => 'Adresse Email',
            'password'  => 'Mot de passe',
        ],
        'no-account'            => 'Sans compte?',
        'or'                    => 'OU',
        'password_forgotten'    => 'Mot de passe oublié?',
        'sign-up'               => 'S\'inscrire',
        'submit'                => 'Se connecter',
        'title'                 => 'Login',
    ],
    'register'  => [
        'already'   => 'Tu as déjà un compte? :login',
        'errors'    => [
            'email_already_taken'   => 'Un compte avec cette adresse email est déjà enregistré.',
            'general_error'         => 'Une erreur est survenue lors de la création du compte. Merci de ressayer.',
        ],
        'fields'    => [
            'email'     => 'Adresse email',
            'name'      => 'Votre nom d\'utilisateur',
            'password'  => 'Mot de passe',
        ],
        'log-in'    => 'Connectes-toi',
        'submit'    => 'S\'inscrire',
        'title'     => 'Inscription',
        'tos'       => 'En enregistrant un compte, tu acceptes nos :terms et :privacy.',
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
    'tfa'       => [
        'helper'    => 'L\'authentification à deux facteurs est activée. Prière d\'indiquer le code à usage unique fourni par l\'application d\'authentification.',
        'title'     => 'Authentification à deux facteurs',
    ],
    'throttle'  => 'Trop d\'essais. Réessaies dans :seconds secondes.',
    'x-twitter' => 'X anciennement connu comme Twitter',
];
