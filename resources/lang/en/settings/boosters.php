<?php

return [
    'actions'   => [
        'boost_name'    => 'Boost :name',
    ],
    'benefits'  => [
        'boosted'       => 'Boosting a campaign with :one booster will unlock access to the :marketplace, theming options, larger uploads for all members, recovering deleted entities, and :more.',
        'more'          => 'more amazing features',
        'superboosted'  => 'Superboosting a campaign with :amount boosters will unlock all the benefits of a boosted campaign, as well as a campaign gallery, full logs changes are made to entities, and :more.',
    ],
    'intro'     => [
        'anyone'    => 'You aren\'t limited to only boosting campaigns you\'ve created. You can boost any campaign you are a part of or can see. This includes campaigns where you are a player, or :public you enjoy.',
        'data'      => 'When a campaign is no longer boosted, access to boosted features is removed. However, no content is deleted, so boosting the campaign again in the future restores access to it.',
        'first'     => 'Advanced features are unlocked by assigning your boosters to boost or superboost to a campaign. The amount of boosters you have is determined by your :subscription. This number is available to you at all time while you are a subscriber. Boosting a campaign will assign one of your boosters to it, while superboosting a campaign assigns three of them.',
    ],
    'title'     => 'Campaign Boosters',

    'pitch' => [
        'title' => 'Take a campaign to the next level with customisation and perks for all of it\'s members',
        'description' => 'Assign boosters to campaigns and help unlock amazing features for everyone involved. Not impressed by boosted campaigns? We\'ve got you covered with superboosted campaigns!',
        'benefits' => [
            'title' => 'Boosted campaigns get',
            'customisable' => 'Full customisation of the look of a campaign',
            'upload' => 'Bigger upload size for all campaign members',
            'entities' => 'Better control over how entities behave and appear',
            'backup' => 'Recover a previously deleted entity for up to :amount days',
            'icons' => 'Access to thousands of beautiful icons for maps and timelines',
            'relations' => 'Explore an entity\'s relations visually in a visual explorer',
        ],
        'more' => 'Check out the full list of perks on our :boosters page.'
    ],
    'ready' => [
        'title' => 'Boost a campaign',
        'pricing' => 'All of your subscription levels include at least one campaign boosters and start :amount per month.',
        'pricing-amount' => ':currency:amount',
        'available' => 'Your available campaign boosters.',
    ],
    'campaign' => [
        'unboosted' => 'Unboosted',
        'boosted' => 'Boosted by :user since :time',
        'superboosted' => 'Superboosted by :user since :time',
    ],
    'unboost' => [
        'title' => 'Unboosting a campaign',
        'warning' => 'Are you sure you want to stop :action :campaign? This will release your assigned boosters, and hide all content and features related to the perks until the campaign is boosted again.',
        'confirm' => 'Yes, I\'m sure',
        'status' => [
            'superboosting' => 'superboosting',
            'boosting' => 'boosting',
        ],
        'success' => 'The :campaign campaign is no longer boosted, and your boosters are available again.',
    ],
    'boost' => [
        'pitch' => 'Become a subscriber to unlock campaign boosters.',
        'title' => 'Boost :campaign',
        'upgrade' => 'upgrade your subscription',
        'confirm' => 'How exciting! You\'re about to boost :campaign. This will assign one (:cost) of your available campaign boosters.',
        'duration' => 'Assigned boosters remain assigned until you manually remove them, or when your subscription ends.',

        'actions' => [
            'remove' => 'Stop boosting :campaign',
            'confirm' => 'Boost it!',
            'subscribe' => 'Subscribe to Kanka',
            'upgrade' => 'Upgrade your subscription',
        ],
        'errors' => [
            'boosted' => 'Oh oh, looks like :campaign is already boosted!',
            'out-of-boosters' => 'Oh no! You don\'t have enough boosters available. You have :available and need :cost. Either stop boosting other campaigns, or :upgrade.',
        ],
        'success' => 'The :campaign campaign is now boosted. Enjoy all the new awesome features!',
    ],
    'superboost' => [
        'title' => 'Superboost :campaign',
        'actions' => [
        'confirm' => 'Superboost it!',            'remove' => 'Stop superboosting :campaign',

        ],
        'upgrade' => 'Ready for the ultimate Kanka experience? Superboosting :campaign will assign :cost additional campaign boosters.',
        'confirm' => 'How exciting! You\'re about to superboost :campaign. This will assign three (:cost) of your available campaign boosters.',
        'errors' => [
            'boosted' => 'Oh oh, looks like :campaign is already superboosted!',
        ],
        'success' => 'The :campaign campaign is now superboosted. Enjoy all the new awesome features!',
    ]
];
