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
        'email'                     => [
            'body'  => '<p>Bienvenue sur kanka.io!</p><p>Ton compte a bien été créé avec cette adresse email.</p>',
            'login' => 'Se connecter',
            'title' => 'Commencer avec Kanka!',
        ],
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
        'welcome_email'             => [
            'header'        => 'Bienvenue sur Kanka :name!',
            'header_sub'    => 'Félicitations, tu as fait le premier pas dans la création de ton monde sur :kanka!',
            'section_1'     => 'Que faire maintenant?',
            'section_10'    => 'Patrons',
            'section_11'    => 'Crée ton monde,',
            'section_2'     => 'La ressource la plus importante est :discord, où tu trouveras de nombreux utilisateurs dévoués, une équipe d\'accueil, ainsi que le fondateur de Kanka, qui pourront répondre à toutes tes questions.',
            'section_3'     => 'Notre :faq couvre également les questions les plus courantes.',
            'section_4'     => 'Notre :youtube propose des vidéos couvrant les bases de Kanka. Même si tous les sujets ne sont pas encore couverts, on ajoute régulièrement des nouvelles vidéos.',
            'section_5'     => 'chaîne Youtube',
            'section_6'     => 'Nous contacter',
            'section_7'     => 'Si tu n\'as pas trouvé de réponse à tes questions, ou si tu souhaites simplement nous contacter, tu peux nous trouver sur :facebook, ou tu peux nous envoyer un courriel à :email. On est une petite équipe de 2 amis, mais on répond à chaque e-mail qu’on reçoit, donc n\'hésite pas!',
            'section_8'     => 'Une dernière chose',
            'section_9'     => 'On a fait en sorte que toutes les fonctionnalités de base de Kanka soient gratuites, et elles le seront toujours. Cependant, si tu souhaites nous soutenir dans ce projet, tu peux rejoindre nos rangs de :patrons, et accéder à des fonctionnalités additionnelles, ainsi qu\'à notre gratitude éternelle!',
            'title'         => 'Commencer avec Kanka!',
        ],
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
