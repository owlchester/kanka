<?php

return [
    'actions'       => [
        'remove'    => 'Remove premium',
        'unlock'    => 'Go premium',
    ],
    'create'        => [
        'actions'   => [
            'confirm'   => 'Go premium!',
        ],
        'confirm'   => 'How exciting! You\'re about to unlock premium features for :campaign. This will use one of your available premium campaigns.',
        'duration'  => 'Premium campaigns stay that way until you manually remove them, or your subscription ends.',
        'pitch'     => 'Become a subscriber to unlock premium campaigns.',
        'success'   => 'The :campaign campaign is now premium. Enjoy all the new awesome features!',
    ],
    'exceptions'    => [
        'already'       => 'Premium features have already been unlocked for this campaign.',
        'out-of-stock'  => 'You don\'t have enough premium campaigns available to unlock this campaign. Either remove the premium status from another campaign, or :upgrade.',
    ],
    'pitch'         => [
        'description'   => 'Go premium on campaigns and help unlock amazing features for everyone involved.',
        'more'          => 'Check out the full list of perks on our :premium page.',
        'title'         => 'Premium campaigns get',
    ],
    'ready'         => [
        'available'         => 'Your available premium campaigns.',
        'pricing'           => 'All of our subscription levels include at least one premium campaign and start :amount per month.',
        'pricing-amount'    => ':currency:amount',
        'title'             => 'Go premium',
    ],
    'remove'        => [
        'confirm'   => 'Yes, I\'m sure',
        'cooldown'  => 'The premium features from :campaign can be removed after :date.',
        'success'   => 'Premium features have been removed from the :campaign campaign. You can now unlock premium features on another campaign.',
        'title'     => 'Removing premium features',
        'warning'   => 'Are you sure you want to remove premium features from :campaign? This will allow you to unlock another campaign, and hide all content and features related to the perks until the campaign\'s premium status is re-enabled.',
    ],
];
