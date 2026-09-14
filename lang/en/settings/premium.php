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
        'more'      => 'Plus custom themes, plugins, family trees, custom category, and more. This is just a preview of everything unlocked. Premium campaigns stay that way until you manually remove them, or your subscription ends.',
        'pitch'    => 'A preview of what :name gains the moment you upgrade, and there\'s more where this came from.',
        'success'       => 'The :campaign campaign is now premium. Enjoy all the new awesome features!',
        'subtitle'      => 'You\'re about to unlock premium for :name. Here\'s a few highlights of what changes immediately.',
        'recap' => [
            'control' => [
                'title' => 'Full control',
                'description' => 'Change the sidebar, categories, and more.',
            ],
            'instant' => 'members get upgraded instantly',
            'members' => [
                'title' => 'Unlimited',
                'description' => 'roles & members',
            ],
            'size' => 'per-member upload limit',
            'recovery' => [
                'title' => ':amount days',
                'description' => 'undo window for deletions',
            ],
            'icons' => 'icons unlocked for this world',
            'gallery' => 'more storage space for images and assets',
        ],
        'no-stock' => 'Oh no, looks like you don\'t have enough premium campaigns available to unlock this campaign. You can either remove the premium status from another campaign, or :upgrade.',
    ],
    'exceptions'    => [
        'already'       => 'Premium features have already been unlocked for this campaign.',
        'out-of-stock'  => 'You don\'t have enough premium campaigns available to unlock this campaign. Either remove the premium status from another campaign, or :upgrade.',
    ],
    'pitch'         => [
        'description'   => 'Premium features apply to the whole campaign, with every members sees the upgrade the moment you flip the switch.',
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
