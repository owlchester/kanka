<?php

return [
    'menu' => [
        'personal_settings' => 'Personal Settings',
        'profile' => 'Profile',
        'account' => 'Account',
        'layout' => 'Layout',
        'api' => 'API',
    ],
    'account' => [
        'title' => 'Account',
        'email' => 'Change email',
        'description' => 'Update your account',
        'password' => 'Change password',
        'actions' => [
            'update_password' => 'Update password',
            'update_email' => 'Update email',
        ],
        'password_success' => 'Password updated.',
        'email_success' => 'Email updated.',
    ],
    'api' => [
        'title' => 'API',
        'description' => 'Update your API settings',
        'request_permission' => 'We are currently building a powerful RESTful API so that third-party apps can connect to the app. However, we are currently limiting the number of users who can interact with the API while we polish it. If you want to get access to the API and build cools apps that talk with Kanka, please contact us and we\'ll send you all the information you need.',
        'experimental' => 'Welcome to the Kanka APIs! These features are still experimental but should be stable enough for you to start communicating with the APIs. Create a Personal Access Token to use in your api requests, or use the Client token if you want your app to have access to user data.',
    ],
    'layout' => [
        'title' => 'Layout',
        'description' => 'Update your layout options',
        'success' => 'Layout options updated.',
    ],
    'profile' => [
        'title' => 'Personal Profile',
        'description' => 'Update your profile',
        'avatar' => 'Profile Picture',
        'actions' => [
            'update_profile' => 'Update profile',
        ],
        'success' => 'Profile updated.',
    ]
];
