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
        'permanent' => 'Máš permanentný zákaz.',
        'temporary' => '{1} Máš zákaz na :days deň.|[2,4] Máš zákaz na :days dni.|[5,*] Máš zákaz na :days dní.',
    ],
    'confirm'   => [
        'confirm'   => 'Potvrdiť',
        'error'     => 'Nesprávne heslo, prosím skús ešte raz.',
        'helper'    => 'Prosím potvrď tvoje heslo, aby bolo možné pokračovať.',
        'title'     => 'Potvrdenie hesla',
    ],
    'continue'  => [
        'facebook'  => 'Pokračovať cez Facebook',
        'google'    => 'Pokračovať cez Google',
        'x'         => 'Pokračovať cez X',
    ],
    'failed'    => 'Prihlasovacie údaje nie sú správne.',
    'helpers'   => [
        'password'  => 'Zobraziť / Skryť heslo',
    ],
    'login'     => [
        'fields'                => [
            '2fa'       => 'Jednorazové heslo',
            'email'     => 'E-mail',
            'password'  => 'Heslo',
        ],
        'login_with_facebook'   => 'Prihlásenie cez Facebook',
        'login_with_google'     => 'Prihlásenie cez Google',
        'login_with_x'          => 'Prihlásenie cez X (pôvodne Twitter)',
        'new_account'           => 'Registrovať nové konto',
        'no-account'            => 'Nemáš ešte konto?',
        'or'                    => 'ALEBO',
        'password_forgotten'    => 'Zabudnuté heslo?',
        'remember_me'           => 'Zapamätaj si ma',
        'sign-up'               => 'Registruj sa',
        'submit'                => 'Prihlásiť',
        'title'                 => 'Prihlásenie',
    ],
    'register'  => [
        'already'                   => 'Máš už konto? :login',
        'errors'                    => [
            'email_already_taken'   => 'Konto s touto e-mailovou adresou už existuje.',
            'general_error'         => 'Nastala chyba pri registrácii tvojho konta. Prosím, skús to znovu.',
        ],
        'fields'                    => [
            'email'     => 'E-mail',
            'name'      => 'Meno užívateľa',
            'password'  => 'Heslo',
            'tos_clean' => 'Súhlasím s :privacy',
        ],
        'log-in'                    => 'Prihlásenie',
        'register_with_facebook'    => 'Registrácia cez Facebook',
        'register_with_google'      => 'Registrácia cez Google',
        'register_with_x'           => 'Registrácia cez X (pôvodne Twitter)',
        'submit'                    => 'Registrovať',
        'title'                     => 'Registrácia',
        'tos'                       => 'Registráciou konta súhlasíš s našimi :terms a :privacy.',
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
    'tfa'       => [
        'helper'    => 'Dvojstupňové overenie identity je aktívne. Zadaj prosím jednorazové heslo z tvojej autentifikačnej aplikácie.',
        'title'     => 'Dvojstupňové overenie identity',
    ],
    'throttle'  => 'Prekročený limit pokusov. Skús to znovu o :seconds sekúnd.',
    'x-twitter' => 'X pôvodne známy ako Twitter',
];
