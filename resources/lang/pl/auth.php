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

    'failed'    => 'Błędny login lub hasło.',
    'helpers'   => [
        'password'  => 'Pokaż/ukryj hasło',
    ],
    'login'     => [
        'fields'                => [
            'email'     => 'Email',
            'password'  => 'Hasło',
        ],
        'login_with_facebook'   => 'Zaloguj przez Facebooka',
        'login_with_google'     => 'Zaloguj przez Google',
        'login_with_twitter'    => 'Zaloguj przez Twittera',
        'new_account'           => 'Zarejestruj nowe konto',
        'or'                    => 'LUB',
        'password_forgotten'    => 'Nie pamiętasz hasła?',
        'remember_me'           => 'Zapamiętaj',
        'submit'                => 'Zaloguj',
        'title'                 => 'Logowanie',
    ],
    'register'  => [
        'already_account'           => 'Masz już konto?',
        'errors'                    => [
            'email_already_taken'   => 'Istnieje już konto związane z tym adresem email.',
            'general_error'         => 'Podczas rejestracji wystąpił błąd. Spróbuj jeszcze raz.',
        ],
        'fields'                    => [
            'email'     => 'Email',
            'name'      => 'Nazwa użytkownika',
            'password'  => 'Hasło',
            'tos'       => 'Zgadzam się na <a href=":privacyUrl" target="_blank">Privacy Policy</a>.',
            'tos_clean' => 'Akceptuję :privacy',
        ],
        'register_with_facebook'    => 'Zarejestruj przez Facebooka',
        'register_with_google'      => 'Zarejestruj przez Google',
        'register_with_twitter'     => 'Zarejestruj przez Twittera',
        'submit'                    => 'Zarejestruj',
        'title'                     => 'Rejestracja',
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
    'throttle'  => 'Za dużo nieudanych prób logowania. Proszę spróbować za :seconds sekund.',
];
