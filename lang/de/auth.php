<?php

return [
    'banned'    => [
        'permanent' => 'Du wurdest dauerhaft gesperrt.',
        'temporary' => '{1} Du wurdest gesperrt für :days day|[2,*] Du wurdest gesperrt für :days days',
    ],
    'confirm'   => [
        'confirm'   => 'Bestätigung',
        'error'     => 'Falsche Kennwort. Bitte versuchen Sie es erneut.',
        'helper'    => 'Bitte bestätigen Sie Ihr Passwort, bevor Sie fortfahren können.',
        'title'     => 'Passwort Bestätigung',
    ],
    'failed'    => 'Wir kennen diese Logindaten nicht.',
    'helpers'   => [
        'password'  => 'Passwort anzeigen / verbergen',
    ],
    'login'     => [
        'fields'                => [
            '2fa'       => 'Einmaliges Passwort',
            'email'     => 'Email',
            'password'  => 'Passwort',
        ],
        'login_with_facebook'   => 'Login mit Facebook',
        'login_with_google'     => 'Login mit Google',
        'new_account'           => 'Registriere einen neuen Account',
        'or'                    => 'ODER',
        'password_forgotten'    => 'Passwort vergessen?',
        'remember_me'           => 'Benutzerdaten merken',
        'submit'                => 'Login',
        'title'                 => 'Login',
    ],
    'register'  => [
        'already'                   => 'Hast du schon ein Konto? :login',
        'errors'                    => [
            'email_already_taken'   => 'Ein Account mit dieser Email ist bereits registriert.',
            'general_error'         => 'Beim erstellen des Accounts ist ein Fehler aufgetreten. Bitte erneut versuchen.',
        ],
        'fields'                    => [
            'email'     => 'Email',
            'name'      => 'Nutzername',
            'password'  => 'Passwort',
            'tos_clean' => 'Ich stimme der :privacy zu',
        ],
        'log-in'                    => 'Log in',
        'register_with_facebook'    => 'Mit Facebook registrieren',
        'register_with_google'      => 'Mit Google registrieren',
        'submit'                    => 'Registrieren',
        'title'                     => 'Registrieren',
        'tos'                       => 'Durch die Registrierung eines Kontos stimmst du unseren :terms und :privacy zu.',
    ],
    'reset'     => [
        'fields'    => [
            'email'                 => 'Email Adresse',
            'password'              => 'Passwort',
            'password_confirmation' => 'Passwort bestätigen',
        ],
        'send'      => 'Link zum zurücksetzen des Passwords verschickt',
        'submit'    => 'Passwort zurücksetzen',
        'title'     => 'Passwort zurücksetzen',
    ],
    'tfa'       => [
        'helper'    => 'Die Zwei-Faktor-Authentifizierung ist aktiviert. Bitte gib das von dir Authentifizierungs-App bereitgestellte One Time Password (OTP) an.',
        'title'     => 'Zwei-Faktor-Authentifizierung',
    ],
    'throttle'  => 'Zu viele Anmeldeversuche. Bitte versuche es in :seconds Sekunden noch einmal.',
];
