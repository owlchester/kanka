<?php

return [
    'actions' => [
        'update' => 'Update password',
    ],
    'title' => 'Update your account password',
    'subtitle' => 'Change your account password. This will log you out of all other devices.',
    'fields' => [
        'password' => 'New password',
        'password_confirmation' => ''
    ],
    'helpers' => [
        'password' => 'Use a password manager to generate a strong password.',
        'password_confirmation' => 'Don\'t mess up!',
    ]
];
