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
    'boost'     => [
        'benefits'      => [
            'first'     => 'To secure continued progress on Kanka, some campaign features are unlocked by boosting a campaign. Boosts are unlocked through subscriptions. Anyone who can view a campaign can boost it, so that the DM doesn\'t always have to foot the bill. A campaign remains boosted as long as a user is boosting the campaign and they continue supporting Kanka. If a campaign is no longer boosted, data isn\'t lost, it is only hidden until the campaign is boosted again.',
            'header'    => 'Entity header images.',
            'more'      => 'Find out more about all features.',
            'second'    => 'Boosting a campaign enables the following benefits:',
            'theme'     => 'Campaign level theme and custom styling.',
            'tooltip'   => 'Custom tooltips for entities.',
            'upload'    => 'Increased upload size for every member in the campaign.',
        ],
        'buttons'       => [
            'boost' => 'Boost',
        ],
        'campaigns'     => 'Boosted Campaigns :count / :max',
        'exceptions'    => [
            'already_boosted'   => 'Campaign :name is already boosted.',
            'exhausted_boosts'  => 'You are out of boosts to give. Remove your boost from a campaign before giving it to another.',
        ],
        'success'       => [
            'boost' => 'Campaign :name boosted.',
            'delete'=> 'Removed your boost from :name.',
        ],
        'title'         => 'Boost',
    ],
    'layout'    => [
        'description'   => 'Update your layout options',
        'success'       => 'Layout options updated.',
        'title'         => 'Layout',
    ],
    'menu'      => [
        'account'           => 'Account',
        'api'               => 'API',
        'billing'           => 'Payment Method',
        'boost'             => 'Boost',
        'layout'            => 'Layout',
        'patreon'           => 'Patreon',
        'personal_settings' => 'Personal Settings',
        'profile'           => 'Profile',
        'subscription'      => 'Subscription',
        'subscription_status' => 'Subscription Status',
        'payment_options' => 'Payment Options',
    ],
    'patreon'   => [
        'actions'           => [
            'link'  => 'Link Account',
            'view'  => 'Visit Kanka on Patreon',
        ],
        'benefits'          => 'Supporting us on :patreon unlocks all sorts of :features for you and your campaigns, and also helps us spend more time working on improving Kanka.',
        'benefits_features' => 'amazing features',
        'description'       => 'Syncing with Patreon',
        'errors'            => [
            'invalid_token' => 'Invalid token! Patreon couldn\'t validate your request.',
            'missing_code'  => 'Missing code! Patreon didn\'t send back a code identifying your account.',
            'no_pledge'     => 'No pledge! Patreon identified your account, but doesn\'t know of any active pledge.',
        ],
        'link'              => 'Use the following button if you are currently supporting Kanka on :patreon. This will unlock the bonuses',
        'linked'            => 'Thank you for supporting Kanka on Patreon! Your account is linked.',
        'pledge'            => 'Pledge: :name',
        'success'           => 'Thank you for supporting Kanka on Patreon!',
        'title'             => 'Patreon',
        'wrong_pledge'      => 'Your pledge level is set manually by us, so please allow up to a few days for us to properly set it. If it stays wrong for a while, please contact us.',
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
    'subscription' => [
        'billing' => [
            'title' => 'Edit Payment Method',
            'helper' => 'Your billing information is processed and stored safely through :stripe. This payment method is used for all of your subscriptions.',
            'saved' => 'Saved payment method',
        ],
        'cancel' => [
            'text' => 'Sorry to see you go! Cancelling your subscription will keep it active until your next billing cycle, after which you will lose your campaign boosts and other benefits related to supporting Kanka. Feel free to fill out the following form to inform us what we can do better, or what lead to your decision.',
        ],
        'currencies' => [
            'eur' => 'Euro',
            'usd' => 'USD',
        ],
        'manage_subscription' => 'Manage your subscription',
        'benefits'          => 'By supporting us, you can unlock some new :features and help is invest more time into improving Kanka. No credit card information is stored or transits through our servers. We use :strip to handle all billing.',
        'sub_status' => 'Subscription information',
        'fields' => [
            'currency' => 'Billing Currency',
            'plan' => 'Current plan',
            'billed_monthly' => 'Billed monthly',
            'active_since' => 'Active since',
            'active_until' => 'Active until',
            'payment_method' => 'Payment method',
            'reason' => 'Reason',
        ],
        'actions' => [
            'cancel_sub' => 'Cancel subscription',
            'update_currency' => 'Save prefered currency'
        ],
        'placeholders' => [
            'reason' => 'Optionally tell us why you are no longer supporting Kanka. Was a feature missing? Did your financial situation change?'
        ],
        'payment_method' => [
            'card' => 'Card',
            'card_name' => 'Name on card',
            'new_card' => 'Add a new payment method',
            'add_one' => 'You currently have no payment method saved.',
            'actions' => [
                'save' => 'Save payment method',
                'add_new' => 'Add a new payment method',
            ],
            'helper' => 'This card will be used for all of your subscriptions.',
            'select' => 'Select a method payment',
            'ending' => 'Ending in',
            'saved' => ':brand ending with :last4'
        ],
        'subscription' => [
            'select' => 'Select subscription',
            'actions' => [
                'subscribe' => 'Subscribe',
                'processing' => 'Processing',
            ],
        ],
        'success' => [
            'currency' => 'Your prefered currency setting was updated.',
            'cancel' => 'Your subscription was cancelled.',
            'subscribed' => 'Your subscription was successful.',
        ],
        'errors' => [
            'subscribed' => 'Couldn\'t process your subscription. Stripe provided the following hint.',
        ]
    ]
];
