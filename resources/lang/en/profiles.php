<?php

return [
    'title' => 'Update your profile',
    'description' => 'Update your profile details',

    'edit' => [
        'success' => 'Profile updated',
    ],

    'fields' => [
        'name' => 'Name',
        'email' => 'Email',
        'new_password' => 'New Password (optional)',
        'new_password_confirmation' => 'New Password Confirmation',
        'password' => 'Current password',
        'avatar' => 'Avatar',
        'newsletter' => 'I wish to sometimes be contacted by email.',
    ],
    'placeholders' => [
        'name' => 'Your name as displayed',
        'email' => 'Your email address',
        'new_password' => 'Your new password',
        'new_password_confirmation' => 'Confirm your new password',
        'password' => 'Provide your current password for any changes'
    ],
    'sections' => [
        'password' => [
            'title' => 'Change your password',
        ],
        'delete' => [
            'title' => 'Delete your account',
            'warning' => 'By deleting your account, all your data will be lost. Are you sure?',
            'delete' => 'Delete my account',
        ]
    ],
    'password' => [
        'success' => 'Password updated',
    ]
];
