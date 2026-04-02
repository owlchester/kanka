<?php

return [
    'actions'       => [
        'remove'    => 'Remove premium',
        'unlock'    => 'Go premium',
    ],
    'create'        => [
        'actions'       => [
            'confirm'   => 'Go premium!',
        ],
        'confirm'       => 'How exciting! You\'re about to unlock premium features for :campaign. This will use one of your available premium campaigns.',
        'duration'      => 'Premium campaigns stay that way until you manually remove them, or your subscription ends.',
        'pitch_2026'    => 'Get unlimited roles, members, custom themes, plugins, and more for your campaigns.',
        'success'       => 'The :campaign campaign is now premium. Enjoy all the new awesome features!',
    ],
    'exceptions'    => [
        'already'       => 'Premium features have already been unlocked for this campaign.',
        'out-of-stock'  => 'You don\'t have enough premium campaigns available to unlock this campaign. Either remove the premium status from another campaign, or :upgrade.',
    ],
    'pitch'         => [
        'description'   => 'Premium features apply to the whole campaign, including all of its members.',
        'title'         => 'Premium campaigns get',
    ],
    'ready'         => [
        'available'         => 'Your available premium campaigns.',
        'pricing'           => 'All of our subscription levels include at least one premium campaign and start at :amount per month.',
        'pricing-amount'    => ':currency:amount',
        'title'             => 'Go premium',
    ],
    'remove'        => [
        'confirm'   => 'Yes, I\'m sure',
        'cooldown'  => 'The premium features from :campaign can be removed after :date.',
        'success'   => 'Premium features have been removed from :campaign. You can now unlock premium features on another one.',
        'title'     => 'Removing premium features',
        'warning'   => 'Are you sure you want to remove premium features from :campaign? This will allow you to unlock another one, and hide all content and features related to the perks until the campaign\'s premium status is re-enabled.',
    ],
];
