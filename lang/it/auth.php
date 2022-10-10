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
    'confirm'   => [
        'confirm'   => 'Conferma',
        'error'     => 'Password non valida, riprova.',
        'helper'    => 'Conferma la tua password prima di continuare',
        'title'     => 'Conferma della password',
    ],
    'failed'    => 'Credenziali non corrispondenti ai dati registrati.',
    'helpers'   => [
        'password'  => 'Mostra / Nascondi password',
    ],
    'login'     => [
        'fields'                => [
            'email'     => 'Email',
            'password'  => 'Password',
        ],
        'login_with_facebook'   => 'Accedi con Facebook',
        'login_with_google'     => 'Accedi con Google',
        'login_with_twitter'    => 'Accedi con Twitter',
        'new_account'           => 'Registra un nuovo account',
        'or'                    => 'OPPURE',
        'password_forgotten'    => 'Password dimenticata?',
        'remember_me'           => 'Ricordami',
        'submit'                => 'Accedi',
        'title'                 => 'Accedi',
    ],
    'register'  => [
        'already_account'           => 'Hai già un account?',
        'errors'                    => [
            'email_already_taken'   => 'Un account con questa email è già stato registrato.',
            'general_error'         => 'C\'è stato un errore durante la registrazione del tuo account. Per favore riprova.',
        ],
        'fields'                    => [
            'email'     => 'Email',
            'name'      => 'Nome Utente',
            'password'  => 'Password',
            'tos_clean' => 'Accetto le condizioni :privacy',
        ],
        'register_with_facebook'    => 'Registrati con Facebook',
        'register_with_google'      => 'Registrati con Google',
        'register_with_twitter'     => 'Registrati con Twitter',
        'submit'                    => 'Registrati',
        'title'                     => 'Registrati',
    ],
    'reset'     => [
        'fields'    => [
            'email'                 => 'Indirizzo Email',
            'password'              => 'Password',
            'password_confirmation' => 'Conferma la password',
        ],
        'send'      => 'Invia il Link di Reset Password',
        'submit'    => 'Resetta la password',
        'title'     => 'Resetta la password',
    ],
    'throttle'  => 'Troppi tentativi di accesso. Riprova tra :seconds secondi.',
];
