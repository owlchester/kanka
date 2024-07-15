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

    'failed'    => 'Rossz email-jelszó páros.',
    'helpers'   => [
        'password'  => 'Jelszó megmutatása / elrejtése',
    ],
    'login'     => [
        'fields'                => [
            'email'     => 'Email',
            'password'  => 'Jelszó',
        ],
        'login_with_facebook'   => 'Bejelentkezés Facebook segítségével',
        'login_with_google'     => 'Bejelentkezés Google segítségével',
        'new_account'           => 'Új felhasználói fiók regisztrálása',
        'or'                    => 'VAGY',
        'password_forgotten'    => 'Elfelejtetted a jelszavadat?',
        'remember_me'           => 'Emlékezz rám',
        'submit'                => 'Bejelentkezés',
        'title'                 => 'Bejelentkezés',
    ],
    'register'  => [
        'errors'                    => [
            'email_already_taken'   => 'Ehhez az email-hez már regisztráltak felhasználói fiókot.',
            'general_error'         => 'Hiba lépett fel a regisztráció folyamán. Kérlek, próbáld meg újra!',
        ],
        'fields'                    => [
            'email'     => 'Email',
            'name'      => 'Felhasználónév',
            'password'  => 'Jelszó',
            'tos_clean' => 'Egyetértek a :privacy',
        ],
        'register_with_facebook'    => 'Regisztráció a Facebook segítségével',
        'register_with_google'      => 'Regisztráció a Google segítségével',
        'submit'                    => 'Regisztráció',
        'title'                     => 'Regisztráció',
    ],
    'reset'     => [
        'fields'    => [
            'email'                 => 'Email-cím',
            'password'              => 'Jelszó',
            'password_confirmation' => 'Jelszó megerősítése',
        ],
        'send'      => 'Jelszó visszaállító link küldése',
        'submit'    => 'Jelszó visszaállítása',
        'title'     => 'Jelszó visszaállítása',
    ],
    'throttle'  => 'Túl sok próbálkozás. Kérjük, próbálja újra :seconds másodperc múlva!',
];
