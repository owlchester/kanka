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

    'failed'    => 'Prihlasovacie údaje nie sú správne.',
    'helpers'   => [
        'password'  => 'Zobraziť / Skryť heslo',
    ],
    'login'     => [
        'fields'                => [
            'email'     => 'E-mail',
            'password'  => 'Heslo',
        ],
        'login_with_facebook'   => 'Prihlásenie cez Facebook',
        'login_with_google'     => 'Prihlásenie cez Google',
        'login_with_twitter'    => 'Prihlásenie cez Twitter',
        'new_account'           => 'Registrovať nové konto',
        'or'                    => 'ALEBO',
        'password_forgotten'    => 'Zabudnuté heslo?',
        'remember_me'           => 'Zapamätaj si ma',
        'submit'                => 'Prihlásiť',
        'title'                 => 'Prihlásenie',
    ],
    'register'  => [
        'already_account'           => 'Máš už vlastné konto?',
        'errors'                    => [
            'email_already_taken'   => 'Konto s touto e-mailovou adresou už existuje.',
            'general_error'         => 'Nastala chyba pri registrácii tvojho konta. Prosím, skús to znovu.',
        ],
        'fields'                    => [
            'email'     => 'E-mail',
            'name'      => 'Meno užívateľa',
            'password'  => 'Heslo',
            'tos'       => 'Súhlasím s <a href=":privacyUrl" target="_blank">Ochranou osobných údajov</a>.',
            'tos_clean' => 'Súhlasím s :privacy',
        ],
        'register_with_facebook'    => 'Registrácia cez Facebook',
        'register_with_google'      => 'Registrácia cez Google',
        'register_with_twitter'     => 'Registrácia cez Twitter',
        'submit'                    => 'Registrovať',
        'title'                     => 'Registrácia',
    ],
    'reset'     => [
        'fields'    => [
            'email'                 => 'E-mailová adresa',
            'password'              => 'Heslo',
            'password_confirmation' => 'Potvrď svoje heslo',
        ],
        'send'      => 'Zaslať link na obnovenie hesla',
        'submit'    => 'Obnoviť heslo',
        'title'     => 'Obnovenie hesla',
    ],
    'throttle'  => 'Prekročený limit pokusov. Skús to znovu o :seconds sekúnd.',
];
