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

    'failed'    => 'Uneseni korisnički podaci ne odgovaraju našim zapisima.',
    'helpers'   => [
        'password'  => 'Prikaži / sakrij lozinku',
    ],
    'login'     => [
        'fields'                => [
            'email'     => 'Email',
            'password'  => 'Lozinka',
        ],
        'login_with_facebook'   => 'Prijavi se pomoću Facebook računa',
        'login_with_google'     => 'Prijavi se pomoću Google računa',
        'new_account'           => 'Registriraj novi račun',
        'or'                    => 'ILI',
        'password_forgotten'    => 'Zaboravljena lozinka?',
        'remember_me'           => 'Zapamti me',
        'submit'                => 'Prijava',
        'title'                 => 'Prijava',
    ],
    'register'  => [
        'errors'                    => [
            'email_already_taken'   => 'Račun s ovom email adresom je već registriran.',
            'general_error'         => 'Dogodila se pogreška prilikom registracije. Molimo, pokušaj ponovno.',
        ],
        'fields'                    => [
            'email'     => 'Email',
            'name'      => 'Korisničko ime',
            'password'  => 'Lozinka',
        ],
        'register_with_facebook'    => 'Registriraj se pomoću Facebook računa',
        'register_with_google'      => 'Registriraj se pomoću Google računa',
        'submit'                    => 'Registracija',
        'title'                     => 'Registracija',
    ],
    'reset'     => [
        'fields'    => [
            'email'                 => 'Email adresa',
            'password'              => 'Lozinka',
            'password_confirmation' => 'Potvrdi svoju lozinku',
        ],
        'send'      => 'Pošalji poveznicu za ponovno postavljanje lozinke',
        'submit'    => 'Ponovno postavi lozinku',
        'title'     => 'Ponovi lozinku',
    ],
    'throttle'  => 'Previše pokušaja prijave. Molim, pokušaj ponovno za :seconds sekundi.',
];
