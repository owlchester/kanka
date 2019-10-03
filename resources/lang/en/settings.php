<?php

return [
    'account'   => [
        'actions'           => [
            'social'            => 'Switch to Kanka Login',
            'update_email'      => 'Update email',
            'update_password'   => 'Update password',
        ],
        'description'       => 'Update your account',
        'email'             => 'Change email',
        'email_success'     => 'Email updated.',
        'password'          => 'Change password',
        'password_success'  => 'Password updated.',
        'social'            => [
            'error'     => 'You are already using the Kanka login for this account.',
            'helper'    => 'Your account is currently managed by :provider. You can stop using it and switch to the standard Kanka login by setting up a password.',
            'success'   => 'Your account now uses the Kanka login.',
            'title'     => 'Social to Kanka',
        ],
        'title'             => 'Account',
    ],
    'api'       => [
        'description'           => 'Update your API settings',
        'experimental'          => 'Welcome to the Kanka APIs! These features are still experimental but should be stable enough for you to start communicating with the APIs. Create a Personal Access Token to use in your api requests, or use the Client token if you want your app to have access to user data.',
        'help'                  => 'Kanka will soon provide an RESTful API so that third-party apps can connect to the app. Details on how to manage your API keys will be shown here.',
        'link'                  => 'Read the API documentation',
        'request_permission'    => 'We are currently building a powerful RESTful API so that third-party apps can connect to the app. However, we are currently limiting the number of users who can interact with the API while we polish it. If you want to get access to the API and build cools apps that talk with Kanka, please contact us and we\'ll send you all the information you need.',
        'title'                 => 'API',
    ],
    'boost' => [
        'title' => 'Boost',
        'benefits' => [
            'first' => 'To secure continued progress on Kanka, some campaign features are unlocked by boosting a campaign. Boosts are unlocked through :patreon. Anyone who can view a campaign can boost it, so that the DM doesn\'t always have to foot the bill. A campaign reminds boosted as long as a user is boosting the campaign and they continue supporting Kanka on :patreon. If a campaign is no longer boosted, data isn\'t lost, it is only hidden until the campaign is boosted again.',
            'second' => 'Boosting a campaign enables the following benefits:',
            'theme' => 'Fixed and custom campaign theming.',
            'tooltip' => 'Custom tooltips for entities.',
            'header' => 'Entity header images.',
            'upload' => 'Increased upload size for every member in the campaign.',
            'more' => 'More to come.'
        ],
        'campaigns' => 'Boosted Campaigns :count / :max',
        'buttons' => [
            'boost' => 'Boost'
        ],
        'success' => [
            'boost' => 'Campaign :name boosted.',
            'delete' => 'Removed your boost from :name.'
        ],
        'exceptions' => [
            'already_boosted' => 'Campaign :name is already boosted.',
            'exhausted_boosts' => 'You are out of boosts to give. Remove your boost from a campaign before giving it to another.',
        ]
    ],
    'layout'    => [
        'description'   => 'Update your layout options',
        'success'       => 'Layout options updated.',
        'title'         => 'Layout',
    ],
    'menu'      => [
        'account'           => 'Account',
        'api'               => 'API',
        'boost'             => 'Boost',
        'layout'            => 'Layout',
        'patreon'           => 'Patreon',
        'personal_settings' => 'Personal Settings',
        'profile'           => 'Profile',
    ],
    'patreon'   => [
        'actions'       => [
            'link'  => 'Link Account',
            'view'  => 'Visit Kanka on Patreon',
        ],
        'benefits'      => 'Supporting us on Patreon allows you to upload bigger images, helps us cover the server bills, and helps us dedicate more time working on Kanka.',
        'description'   => 'Syncing with Patreon',
        'errors'        => [
            'invalid_token' => 'Invalid token! Patreon couldn\'t validate your request.',
            'missing_code'  => 'Missing code! Patreon didn\'t send back a code identifying your account.',
            'no_pledge'     => 'No pledge! Patreon identified your account, but doesn\'t know of any active pledge.',
        ],
        'link'          => 'Use the following button if you are currently supporting Kanka on :patreon. This will unlock the bonuses',
        'linked'        => 'Thank you for supporting Kanka on Patreon! Your account is linked.',
        'pledge'        => 'Pledge: :name',
        'success'       => 'Thank you for supporting Kanka on Patreon!',
        'title'         => 'Patreon',
        'wrong_pledge'  => 'Your pledge level is set manually by us, so please allow up to a few days for us to properly set it. If it stays wrong for a while, please contact us.',
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
