<?php

return [
    'account'       => [
        'actions'           => [
            'social'            => 'Switch to Kanka Login',
            'update_email'      => 'Update email',
            'update_password'   => 'Update password',
        ],
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
    'api'           => [
        'experimental'          => 'Welcome to the Kanka APIs! These features are still experimental but should be stable enough for you to start communicating with the APIs. Create a Personal Access Token to use in your api requests, or use the Client token if you want your app to have access to user data.',
        'help'                  => 'Kanka will soon provide an RESTful API so that third-party apps can connect to the app. Details on how to manage your API keys will be shown here.',
        'link'                  => 'Read the API documentation',
        'request_permission'    => 'We are currently building a powerful RESTful API so that third-party apps can connect to the app. However, we are currently limiting the number of users who can interact with the API while we polish it. If you want to get access to the API and build cools apps that talk with Kanka, please contact us and we\'ll send you all the information you need.',
        'title'                 => 'API',
    ],
    'apps'          => [
        'actions'   => [
            'connect'   => 'Connect',
            'remove'    => 'Remove',
        ],
        'benefits'  => 'Kanka provides a few integration to third party services. More third party integrations are planned for the future.',
        'discord'   => [
            'errors'    => [
                'add'   => 'An error occurred linking up your Discord account with Kanka. Please try again.',
            ],
            'success'   => [
                'add'       => 'Your Discord account has been linked.',
                'remove'    => 'Your Discord account has been unlinked.',
            ],
            'text'      => 'Access your subscription roles automatically.',
        ],
        'title'     => 'App Integration',
    ],
    'boost'         => [
        'benefits'      => [
            'first'     => 'To secure continued progress on Kanka, some campaign features are unlocked by boosting a campaign. Boosts are unlocked through subscriptions. Anyone who can view a campaign can boost it, so that the DM doesn\'t always have to foot the bill. A campaign remains boosted as long as a user is boosting the campaign and they continue supporting Kanka. If a campaign is no longer boosted, data isn\'t lost, it is only hidden until the campaign is boosted again.',
            'header'    => 'Entity header images.',
            'images'    => 'Custom default entity images.',
            'more'      => 'Find out more about all features.',
            'second'    => 'Boosting a campaign enables the following benefits:',
            'theme'     => 'Campaign level theme and custom styling.',
            'third'     => 'To boost a campaign, go to the campaign\'s page, and click on the ":boost_button" button above the ":edit_button" button.',
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
    'countries'     => [
        'austria'       => 'Austria',
        'belgium'       => 'Belgium',
        'france'        => 'France',
        'germany'       => 'Germany',
        'italy'         => 'Italy',
        'netherlands'   => 'The Netherlands',
        'spain'         => 'Spain',
    ],
    'invoices'      => [
        'actions'   => [
            'download'  => 'Download PDF',
            'view_all'  => 'View all',
        ],
        'empty'     => 'No invoices',
        'fields'    => [
            'amount'    => 'Amount',
            'date'      => 'Date',
            'invoice'   => 'Invoice',
            'status'    => 'Status',
        ],
        'header'    => 'Below is a list of your last 24 invoices which can be downloaded.',
        'status'    => [
            'paid'      => 'Paid',
            'pending'   => 'Pending',
        ],
        'title'     => 'Invoices',
    ],
    'layout'        => [
        'success'   => 'Layout options updated.',
        'title'     => 'Layout',
    ],
    'marketplace' => [
        'title' => 'Marketplace Settings',
        'helper' => 'By default, your user name is shown on the :marketplace. You can override this value with this field.',
        'fields' => [
            'name' => 'Marketplace name',
        ],
        'update' => 'Marketplace settings saved.',
    ],
    'menu'          => [
        'account'               => 'Account',
        'api'                   => 'API',
        'apps'                  => 'Apps',
        'billing'               => 'Payment Method',
        'boost'                 => 'Boost',
        'invoices'              => 'Invoices',
        'layout'                => 'Layout',
        'marketplace'           => 'Marketplace',
        'other'                 => 'Other',
        'patreon'               => 'Patreon',
        'payment_options'       => 'Payment Options',
        'personal_settings'     => 'Personal Settings',
        'profile'               => 'Profile',
        'subscription'          => 'Subscription',
        'subscription_status'   => 'Subscription Status',
    ],
    'patreon'       => [
        'actions'           => [
            'link'  => 'Link Account',
            'view'  => 'Visit Kanka on Patreon',
        ],
        'benefits'          => 'Supporting us on :patreon unlocks all sorts of :features for you and your campaigns, and also helps us spend more time working on improving Kanka.',
        'benefits_features' => 'amazing features',
        'deprecated'        => 'Deprecated feature - if you wish to support Kanka, please do so with a :subscription. Patreon linking is still active for our Patrons who have linked their account before the move away from Patreon.',
        'description'       => 'Syncing with Patreon',
        'linked'            => 'Thank you for supporting Kanka on Patreon! Your account is linked.',
        'pledge'            => 'Pledge: :name',
        'remove'            => [
            'button'    => 'Unlink your Patreon account',
            'success'   => 'Your Patreon account has been unlinked.',
            'text'      => 'Unlinking your Patreon account with Kanka will remove your bonuses, name on the hall of fame, campaign boosts, and other features linked to supporting Kanka. None of your boosted content will be lost (e.g. entity headers). By subscribing again, you will have access to all your previous data, including the ability to boost your previously boosted campaigns.',
            'title'     => 'Unlink your Patreon account with Kanka',
        ],
        'success'           => 'Thank you for supporting Kanka on Patreon!',
        'title'             => 'Patreon',
        'wrong_pledge'      => 'Your pledge level is set manually by us, so please allow up to a few days for us to properly set it. If it stays wrong for a while, please contact us.',
    ],
    'profile'       => [
        'actions'   => [
            'update_profile'    => 'Update profile',
        ],
        'avatar'    => 'Profile Picture',
        'success'   => 'Profile updated.',
        'title'     => 'Personal Profile',
    ],
    'subscription'  => [
        'actions'               => [
            'cancel_sub'        => 'Cancel subscription',
            'subscribe'         => 'Subscribe',
            'update_currency'   => 'Save prefered currency',
        ],
        'benefits'              => 'By supporting us, you can unlock some new :features and help us invest more time into improving Kanka. No credit card information is stored or transits through our servers. We use :stripe to handle all billing.',
        'billing'               => [
            'helper'    => 'Your billing information is processed and stored safely through :stripe. This payment method is used for all of your subscriptions.',
            'saved'     => 'Saved payment method',
            'title'     => 'Edit Payment Method',
        ],
        'cancel'                => [
            'text'  => 'Sorry to see you go! Cancelling your subscription will keep it active until your next billing cycle, after which you will lose your campaign boosts and other benefits related to supporting Kanka. Feel free to fill out the following form to inform us what we can do better, or what lead to your decision.',
        ],
        'cancelled'             => 'Your subscription has been cancelled. You can renew a subscription once your current subscription ends.',
        'change'                => [
            'text'  => [
                'monthly'   => 'You are subscribing at the :tier tier, billed monthly for :amount.',
                'yearly'    => 'You are subscribing at the :tier tier, billed annualy for :amount.',
            ],
            'title' => 'Change Subscription Tier',
        ],
        'currencies'            => [
            'eur'   => 'EUR',
            'usd'   => 'USD',
        ],
        'currency'              => [
            'title' => 'Change your preferred billing currency',
        ],
        'errors'                => [
            'callback'      => 'Our payment provider reported an error. Please try again or contact us if the problem persists.',
            'subscribed'    => 'Couldn\'t process your subscription. Stripe provided the following hint.',
        ],
        'fields'                => [
            'active_since'      => 'Active since',
            'active_until'      => 'Active until',
            'billing'           => 'Billing',
            'currency'          => 'Billing Currency',
            'payment_method'    => 'Payment method',
            'plan'              => 'Current plan',
            'reason'            => 'Reason',
        ],
        'helpers'               => [
            'alternatives'          => 'Pay for your subscription using :method. This payment method won\'t auto-renew at the end of your subscription. :method is only available in Euros.',
            'alternatives_warning'  => 'Upgrading your subscription when using this method is not possible. Please create a new subscription when your current one ends.',
            'alternatives_yearly'   => 'Due to the restrictions surrounding recurring payments, :method is only available for yearly subscriptions',
        ],
        'manage_subscription'   => 'Manage subscription',
        'payment_method'        => [
            'actions'       => [
                'add_new'           => 'Add a new payment method',
                'change'            => 'Change payment method',
                'save'              => 'Save payment method',
                'show_alternatives' => 'Alternative payment options',
            ],
            'add_one'       => 'You currently have no payment method saved.',
            'alternatives'  => 'You can subscribe using these alternative payment options. This action will charge your account once and not auto-renew your subscription every month.',
            'card'          => 'Card',
            'card_name'     => 'Name on card',
            'country'       => 'Country of residence',
            'ending'        => 'Ending in',
            'helper'        => 'This card will be used for all of your subscriptions.',
            'new_card'      => 'Add a new payment method',
            'saved'         => ':brand ending with :last4',
        ],
        'placeholders'          => [
            'reason'    => 'Optionally tell us why you are no longer supporting Kanka. Was a feature missing? Did your financial situation change?',
        ],
        'plans'                 => [
            'cost_monthly'  => ':currency :amount billed monthly',
            'cost_yearly'   => ':currency :amount billed yearly',
        ],
        'sub_status'            => 'Subscription information',
        'subscription'          => [
            'actions'   => [
                'downgrading'       => 'Please contact us for downgrading',
                'rollback'          => 'Change to Kobold',
                'subscribe'         => 'Change to :tier monthly',
                'subscribe_annual'  => 'Change to :tier yearly',
            ],
        ],
        'success'               => [
            'alternative'   => 'Your payment was registered. You will get a notification as soon as it is processed and your subscription is active.',
            'callback'      => 'Your subscription was successful. Your account will be updated as soon as our payment provided informs us of the change (this might take a few minutes).',
            'cancel'        => 'Your subscription was cancelled. It will continue to be active until the end of your current billing period.',
            'currency'      => 'Your prefered currency setting was updated.',
            'subscribed'    => 'Your subscription was successful. Don\'t forget to subscribe to the Community Vote newsletter to be notified when a vote goes live. You can change your newsletter settings in your Profile page.',
        ],
        'tiers'                 => 'Subscription Tiers',
        'trial_period'          => 'Yearly subscriptions have a 14 day cancellation policy. Contact us at :email if you wish to cancel your yearly subscription and get a refund.',
        'upgrade_downgrade'     => [
            'button'    => 'Upgrade & Downgrade Information',
            'downgrade' => [
                'bullets'   => [
                    'end'   => 'Your current tier will stay active until the end of your current billing cycle, after which you will be downgraded to your new tier.',
                ],
                'title'     => 'When downgrading to a lower tier',
            ],
            'upgrade'   => [
                'bullets'   => [
                    'immediate' => 'Your payment method will be billed immediately and you will have access to your new tier.',
                    'prorate'   => 'When upgrading from Owlbear to Elemental, you will only be billed the difference to your new tier.',
                ],
                'title'     => 'When upgrading to a higher tier',
            ],
        ],
        'warnings'              => [
            'incomplete'    => 'We couldn\'t charge your credit card. Please update your credit card information, and we will try charging it again in the next few days. If it fails again, your subscription will be cancelled.',
            'patreon'       => 'Your account is currently linked with Patreon. Please unlink your account in your :patreon settings before switching to a Kanka subscription.',
        ],
    ],
];
