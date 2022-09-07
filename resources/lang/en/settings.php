<?php

return [
    'account'       => [
        'actions'           => [
            'social'            => 'Switch to Kanka Login',
            'update_email'      => 'Update email',
            'update_password'   => 'Update password',
        ],
        'email'             => 'Change email',
        '2fa'               => [
            'title'                     => 'Two Factor Authentication',
            'helper'                    => 'Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity.',
            'enable_instructions'       => 'To start the activation process, click the generate secret button to generate your authentication QR code, then scan it into the Google Authenticator App',
            'generate_qr'               => 'Generate QR Code',
            'activation_instructions'   => 'Scan the following QR Code with your Google Authenticator App:',
            'activation_helper'         => 'To continue with the activation process for Two Factor Authentication on your Account, please do the following:',
            'activation_instructions_2' => 'Enter the OTP provided by the Google Authenticator app to enable 2FA:',
            'enabled'                   => 'Two Factor Authentication is currently enabled on your account.',
            'enable'                    => 'Enable 2FA',
            'disable_helper'            => 'If you want to disable Two Factor Authentication click the button below, keep in mind that this will leave your account vulnerable to anyone that knows your login information.',
            'disable'                   => 'Disable 2FA',
            'disable_confirm'           => 'Disable 2FA Now',
            'social'                    => 'Kanka two factor authentication is only enabled for users that login using their e-mail and password.'
        ],
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
        'helper'    => 'Welcome to the Kanka APIs. Generate a Personal Access Token to use in your API request to gather information about the campaigns you are a part of.',
        'link'      => 'Read the API documentation',
        'title'     => 'API',
    ],
    'apps'          => [
        'actions'   => [
            'connect'   => 'Connect',
            'remove'    => 'Remove',
        ],
        'benefits'  => 'Kanka provides a few integrations to third party services. More third party integrations are planned for the future.',
        'discord'   => [
            'errors'    => [
                'add'   => 'An error occurred linking up your Discord account with Kanka. Please try again. If this keeps happening, please be aware that Discord has a limit on 100 joined servers when using their APIs.',
            ],
            'success'   => [
                'add'       => 'Your Discord account has been linked.',
                'remove'    => 'Your Discord account has been unlinked.',
            ],
            'text'      => 'Access your subscription roles automatically.',
            'unlock'    => 'Unlock Discord roles',
        ],
        'title'     => 'App Integration',
    ],
    'boost'         => [
        'exceptions'    => [
            'already_boosted'       => 'Campaign :name is already being boosted.',
            'exhausted_boosts'      => 'You are out of boosts to give. Remove your boost from a campaign before giving it to another.',
            'exhausted_superboosts' => 'You are out of boosts. You need 3 boosters to superboost a campaign.',
        ],
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
    'menu'          => [
        'account'               => 'Account',
        'api'                   => 'API',
        'appearance'            => 'Appearance',
        'apps'                  => 'Apps',
        'billing'               => 'Payment Method',
        'boosters'              => 'Boosters',
        'invoices'              => 'Invoices',
        'notifications'         => 'Notifications',
        'other'                 => 'Other',
        'patreon'               => 'Patreon',
        'payment_options'       => 'Payment Options',
        'personal_settings'     => 'Personal Settings',
        'profile'               => 'Public profile',
        'settings'              => 'Settings',
        'subscription'          => 'Subscription',
        'subscription_status'   => 'Subscription Status',
    ],
    'patreon'       => [
        'deprecated'    => 'Deprecated feature - if you wish to support Kanka, please do so with a :subscription. Patreon linking is still active for our Patrons who have linked their account before the move away from Patreon.',
        'pledge'        => 'Pledge: :name',
        'remove'        => [
            'button'    => 'Unlink your Patreon account',
            'success'   => 'Your Patreon account has been unlinked.',
            'text'      => 'Unlinking your Patreon account with Kanka will remove your bonuses, name on the hall of fame, campaign boosts, and other features linked to supporting Kanka. None of your boosted content will be lost (e.g. entity headers). By subscribing again, you will have access to all your previous data, including the ability to boost your previously boosted campaigns.',
            'title'     => 'Unlink your Patreon account with Kanka',
        ],
        'title'         => 'Patreon',
    ],
    'profile'       => [
        'actions'   => [
            'update_profile'    => 'Update profile',
        ],
        'avatar'    => 'Profile Picture',
        'success'   => 'Profile updated.',
        'title'     => 'Public Profile',
    ],
    'subscription'  => [
        'actions'               => [
            'cancel_sub'        => 'Cancel subscription',
            'subscribe'         => 'Subscribe',
            'update_currency'   => 'Save prefered currency',
        ],
        'billing'               => [
            'helper'    => 'Your billing information is processed and stored safely through :stripe. This payment method is used for all of your subscriptions.',
            'saved'     => 'Saved payment method',
            'title'     => 'Edit Payment Method',
        ],
        'cancel'                => [
            'options'   => [
                'competitor'        => 'Switching to a competitor',
                'custom'            => 'Other (please specify)',
                'financial'         => 'Financial situation changed',
                'missing_features'  => 'Missing features',
                'not_using'         => 'Not currently using Kanka',
            ],
            'text'      => 'Sorry to see you go! Cancelling your subscription will keep it active until your next billing cycle, after which you will lose your campaign boosts and other benefits related to supporting Kanka. Feel free to fill out the following form to inform us what we can do better, or what lead to your decision.',
        ],
        'cancelled'             => 'Your subscription has been cancelled. You can renew a subscription once your current subscription ends after :date.',
        'change'                => [
            'text'  => [
                'monthly'   => 'You are subscribing at the :tier tier, billed monthly for :amount.',
                'yearly'    => 'You are subscribing at the :tier tier, billed annually for :amount.',
            ],
            'title' => 'Change Subscription Tier',
        ],
        'coupon'                => [
            'check'         => 'Check promo code',
            'invalid'       => 'Invalid promotional code.',
            'label'         => 'Promotional code',
            'percent_off'   => 'We will discount your first yearly subscription by :percent%!',
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
            'alternatives_warning'  => 'Upgrading your subscription when using this method is not possible. Please subscribe again when your current one ends.',
            'alternatives_yearly'   => 'Due to the restrictions surrounding recurring payments, :method is only available for yearly subscriptions',
            'paypal'                => 'Want to use Paypal instead? Contact us at :email if you wish to subscribe to a yearly plan using Paypal.',
            'stripe'                => 'Your billing information is processed and stored safely through :stripe.',
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
        'periods'               => [
            'monthly'   => 'Monthly',
            'yearly'    => 'Yearly',
        ],
        'placeholders'          => [
            'downgrade_reason'  => 'Optionally tell us why you are downgrading your subscription.',
            'reason'            => 'Optionally tell us why you are no longer supporting Kanka. Was a feature missing? Did your financial situation change?',
        ],
        'plans'                 => [
            'cost_monthly'  => ':currency :amount billed monthly',
            'cost_yearly'   => ':currency :amount billed yearly',
        ],
        'sub_status'            => 'Subscription information',
        'subscription'          => [
            'actions'   => [
                'cancel'            => 'Cancel subscription',
                'downgrading'       => 'Please contact us for downgrading',
                'rollback'          => 'Change to Kobold',
                'subscribe'         => 'Change to :tier monthly',
                'subscribe_annual'  => 'Change to :tier yearly',
            ],
        ],
        'success'               => [
            'alternative'   => 'Your payment was registered. You will get a notification as soon as it is processed and your subscription is active.',
            'callback'      => 'Your subscription was successful. Your account will be updated as soon as our payment provider informs us of the change (this might take a few minutes).',
            'cancel'        => 'Your subscription was cancelled. It will continue to be active until the end of your current billing period.',
            'currency'      => 'Your preferred currency setting was updated.',
            'subscribed'    => 'Your subscription was successful! Don\'t forget to subscribe to the Community Vote newsletter to be notified when a vote goes live. Also, you can check out our discord and become part of the community',
        ],
        'tiers'                 => 'Subscription Tiers',
        'trial_period'          => 'Yearly subscriptions have a 14 day cancellation policy. Contact us at :email if you wish to cancel your yearly subscription and get a refund.',
        'upgrade_downgrade'     => [
            'button'    => 'Upgrade & Downgrade Information',
            'cancel'    => [
                'bullets'   => [
                    'bonuses'   => 'Your bonuses stay enabled until the end of your payment period.',
                    'boosts'    => 'The same happens for your boosted campaigns. Boosted features become invisible but aren\'t deleted when a campaign is no longer boosted.',
                    'kobold'    => 'To cancel your subscription, change to the Kobold tier.',
                ],
                'title'     => 'When cancelling your subscription',
            ],
            'downgrade' => [
                'bullets'           => [
                    'end'   => 'Your current tier will stay active until the end of your current billing cycle, after which you will be downgraded to your new tier.',
                ],
                'provide_reason'    => 'If you can, please share with us why you are downgrading your subscription.',
                'title'             => 'When downgrading to a lower tier',
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
