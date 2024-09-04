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
        'permanent' => 'Twoje konto zostało trwale zablokowane.',
        'temporary' => '{1} Twoje konto zostało zablokowane na :days dzień|[2,*] Twoje konto zostało zablokowane na :days dni.',
    ],
    'confirm'   => [
        'confirm'   => 'Potwierdź',
        'error'     => 'Niewłaściwe hasło, spróbuj jeszcze raz',
        'helper'    => 'Przed przejściem dalej potwierdź swoje hasło',
        'title'     => 'Potwierdzenie hasła',
    ],
    'failed'    => 'Błędny login lub hasło.',
    'helpers'   => [
        'password'  => 'Pokaż/ukryj hasło',
    ],
    'login'     => [
        'fields'                => [
            '2fa'       => 'Hasło jednorazowe',
            'email'     => 'Email',
            'password'  => 'Hasło',
        ],
        'login_with_facebook'   => 'Zaloguj przez Facebooka',
        'login_with_google'     => 'Zaloguj przez Google',
        'login_with_x'          => 'Logowanie przez X (dawniej Twitter)',
        'new_account'           => 'Zarejestruj nowe konto',
        'or'                    => 'LUB',
        'password_forgotten'    => 'Nie pamiętasz hasła?',
        'remember_me'           => 'Zapamiętaj',
        'submit'                => 'Zaloguj',
        'title'                 => 'Logowanie',
    ],
    'register'  => [
        'already'                   => 'Masz już konto? :login',
        'errors'                    => [
            'email_already_taken'   => 'Istnieje już konto związane z tym adresem email.',
            'general_error'         => 'Podczas rejestracji wystąpił błąd. Spróbuj jeszcze raz.',
        ],
        'fields'                    => [
            'email'     => 'Email',
            'name'      => 'Nazwa użytkownika',
            'password'  => 'Hasło',
            'tos_clean' => 'Akceptuję :privacy',
        ],
        'log-in'                    => 'Zaloguj się',
        'register_with_facebook'    => 'Zarejestruj przez Facebooka',
        'register_with_google'      => 'Zarejestruj przez Google',
        'register_with_x'           => 'Rejestracja przez X (dawniej Twitter)',
        'submit'                    => 'Zarejestruj',
        'title'                     => 'Rejestracja',
        'tos'                       => 'Rejestrując konto zgadzasz się na nasze :terms i :privacy',
    ],
    'reset'     => [
        'fields'    => [
            'email'                 => 'Adres email',
            'password'              => 'Hasło',
            'password_confirmation' => 'Potwierdź hasło',
        ],
        'send'      => 'Prześlij link to resetowania hasła',
        'submit'    => 'Resetuj hasło',
        'title'     => 'Resetowanie hasła',
    ],
    'tfa'       => [
        'helper'    => 'Włączono autoryzację dwuetapową. Wpisz hasło jednorazowe (OTP) ze swojej aplikacji autoryzującej',
        'title'     => 'Autoryzacja dwuetapowa',
    ],
    'throttle'  => 'Za dużo nieudanych prób logowania. Proszę spróbować za :seconds sekund.',
    'x-twitter' => 'X, dawniej pod nazwą Twitter',
];
