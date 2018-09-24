<?php

return [
    'account'   => [
        'actions'           => [
            'update_email'      => 'Update email',
            'update_password'   => 'Update password',
        ],
        'description'       => 'Update your account',
        'email'             => 'Change email',
        'email_success'     => 'Email updated.',
        'password'          => 'Change password',
        'password_success'  => 'Password updated.',
        'title'             => 'Account',
    ],
    'api'       => [
        'description'           => 'Update your API settings',
        'experimental'          => 'Welcome to the Kanka APIs! These features are still experimental but should be stable enough for you to start communicating with the APIs. Create a Personal Access Token to use in your api requests, or use the Client token if you want your app to have access to user data.',
        'help'                  => 'Kanka will soon provide an RESTful API so that third-party apps can connect to the app. Details on how to manage your API keys will be shown here.',
        'request_permission'    => 'We are currently building a powerful RESTful API so that third-party apps can connect to the app. However, we are currently limiting the number of users who can interact with the API while we polish it. If you want to get access to the API and build cools apps that talk with Kanka, please contact us and we\'ll send you all the information you need.',
        'title'                 => 'API',
    ],
    'layout'    => [
        'description'   => 'Update your layout options',
        'success'       => 'Layout options updated.',
        'title'         => 'Layout',
    ],
    'menu'      => [
        'account'           => 'Account',
        'api'               => 'API',
        'layout'            => 'Layout',
        'personal_settings' => 'Personal Settings',
        'profile'           => 'Profile',
    ],
    'profile'   => [
        'actions'       => [
            'update_profile'    => 'Update profile',
        ],
        'avatar'        => 'Profile Picture',
        'description'   => 'Update your profile',
        'success'       => 'Profile updated.',
        'title'         => 'Personal Profile',
    ],
];
