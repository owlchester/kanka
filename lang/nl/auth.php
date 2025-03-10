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
    'failed'    => 'Deze combinatie van e-mailadres en wachtwoord is niet geldig.',
    'helpers'   => [
        'password'  => 'Wachtwoord weergeven / verbergen',
    ],
    'login'     => [
        'fields'                => [
            'email'     => 'E-mail',
            'password'  => 'Wachtwoord',
        ],
        'or'                    => 'OF',
        'password_forgotten'    => 'Wachtwoord vergeten?',
        'submit'                => 'Log in',
        'title'                 => 'Log in',
    ],
    'register'  => [
        'already'   => 'Heb je al een account? :login',
        'errors'    => [
            'email_already_taken'   => 'Er is al een account met dit e-mailadres geregistreerd.',
            'general_error'         => 'Er is een fout opgetreden bij het registreren van uw account. Probeer het a.u.b. opnieuw.',
        ],
        'fields'    => [
            'email'     => 'E-mail',
            'name'      => 'Gebruikersnaam',
            'password'  => 'Wachtwoord',
        ],
        'submit'    => 'Registreren',
        'title'     => 'Registreren',
    ],
    'reset'     => [
        'fields'    => [
            'email'                 => 'E-mailadres',
            'password'              => 'Wachtwoord',
            'password_confirmation' => 'Bevestig uw wachtwoord',
        ],
        'send'      => 'Stuur Wachtwoord Reset Link',
        'submit'    => 'Wachtwoord opnieuw instellen',
        'title'     => 'Wachtwoord opnieuw instellen',
    ],
    'throttle'  => 'Te veel mislukte loginpogingen. Probeer het over :seconds seconden nogmaals.',
];
