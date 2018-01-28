<?php

return [
    'description'   => 'Aktualisiere deine Profildetails',
    'edit'          => [
        'success'   => 'Profil aktualisert',
    ],
    'fields'        => [
        'avatar'                    => 'Avatar',
        'email'                     => 'Email',
        'name'                      => 'Name',
        'new_password'              => 'Neues Passwort (optional)',
        'new_password_confirmation' => 'Neues Passwort bestätigen',
        'newsletter'                => 'Ich würde gern manchmal per Email kontaktiert werden.',
        'password'                  => 'Aktuelles Passwort',
    ],
    'password'      => [
        'success'   => 'Passwort aktualisiert',
    ],
    'placeholders'  => [
        'email'                     => 'Deine Email Adresse',
        'name'                      => 'Dein Name, wie er dargestellt wird',
        'new_password'              => 'Dein neues Passwort',
        'new_password_confirmation' => 'Bestätige dein neues Passwort',
        'password'                  => 'Gib dein aktuelles Passwort für Änderungen ein',
    ],
    'sections'      => [
        'delete'    => [
            'delete'    => 'Lösche meinen Account',
            'title'     => 'Lösche deinen Account',
            'warning'   => 'Wenn du deinen Account löschst, werden alle Daten gelöscht. Bist du sicher?',
        ],
        'password'  => [
            'title' => 'Ändere dein Passwort',
        ],
    ],
    'title'         => 'Aktualisiere dein Profil',
];
