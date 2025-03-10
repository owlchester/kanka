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
        'permanent' => 'Sei stato bannato permanentemente.',
        'temporary' => '{1} Sei stato bannato per :days giorno|[2,*] Sei stato bannato per :days giorni',
    ],
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
            '2fa'       => 'Password Monouso',
            'email'     => 'Email',
            'password'  => 'Password',
        ],
        'or'                    => 'OPPURE',
        'password_forgotten'    => 'Password dimenticata?',
        'submit'                => 'Accedi',
        'title'                 => 'Accedi',
    ],
    'register'  => [
        'already'   => 'Hai già un account? :login',
        'errors'    => [
            'email_already_taken'   => 'Un account con questa email è già stato registrato.',
            'general_error'         => 'C\'è stato un errore durante la registrazione del tuo account. Per favore riprova.',
        ],
        'fields'    => [
            'email'     => 'Email',
            'name'      => 'Nome Utente',
            'password'  => 'Password',
        ],
        'log-in'    => 'Accedi',
        'submit'    => 'Registrati',
        'title'     => 'Registrati',
        'tos'       => 'Registrando un account, accetti i nostri :terms e la nostra :privacy.',
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
    'tfa'       => [
        'helper'    => 'L\'Autenticazione a Due Fattori è abilitata. Inserisci la Password Monouso fornita dall\'app di autenticazione.',
        'title'     => 'Autenticazione a Due Fattori',
    ],
    'throttle'  => 'Troppi tentativi di accesso. Riprova tra :seconds secondi.',
    'x-twitter' => 'X, conosciuto precedentemente come Twitter',
];
