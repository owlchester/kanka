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
    'continue'  => [
        'facebook'  => 'Kontynuuj z Facebook',
        'google'    => 'Kontynuuj z Google',
        'x'         => 'Kontynuuj z X',
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
        'no-account'            => 'Nie masz konta?',
        'or'                    => 'LUB',
        'password_forgotten'    => 'Nie pamiętasz hasła?',
        'sign-up'               => 'Zarejestruj się',
        'submit'                => 'Zaloguj',
        'title'                 => 'Logowanie',
    ],
    'register'  => [
        'already'   => 'Masz już konto? :login',
        'errors'    => [
            'email_already_taken'   => 'Istnieje już konto związane z tym adresem email.',
            'general_error'         => 'Podczas rejestracji wystąpił błąd. Spróbuj jeszcze raz.',
        ],
        'fields'    => [
            'email'     => 'Email',
            'name'      => 'Nazwa użytkownika',
            'password'  => 'Hasło',
        ],
        'log-in'    => 'Zaloguj się',
        'submit'    => 'Zarejestruj',
        'title'     => 'Rejestracja',
        'tos'       => 'Rejestrując konto zgadzasz się na nasze :terms i :privacy',
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
