<?php

return [
    'actions'   => [
        'boost_name'    => 'Boost :name',
    ],
    'available' => 'Premium campaigns :amount/:total',
    'benefits'  => [
        'boosted'       => 'Boosting a campaign with :one booster will unlock access to the :marketplace, theming options, larger uploads for all members, recovering deleted entities, and :more.',
        'more'          => 'more amazing features',
        'superboosted'  => 'Superboosting a campaign with :amount boosters will unlock all the benefits of a boosted campaign, as well as a campaign gallery, full logs changes are made to entities, and :more.',
    ],
    'boost'     => [
        'actions'   => [
            'confirm'   => 'Boost it!',
            'remove'    => 'Stop boosting :campaign',
            'subscribe' => 'Subscribe to Kanka',
            'upgrade'   => 'Upgrade your subscription',
        ],
        'confirm'   => 'How exciting! You\'re about to boost :campaign. This will assign one (:cost) of your available campaign boosters.',
        'duration'  => 'Assigned boosters remain assigned until you manually remove them, or when your subscription ends.',
        'errors'    => [
            'boosted'           => 'Oh oh, looks like :campaign is already boosted!',
            'out-of-boosters'   => 'Oh no! You don\'t have enough boosters available. You have :available and need :cost. Either stop boosting other campaigns, or :upgrade.',
        ],
        'pitch'     => 'Become a subscriber to unlock campaign boosters.',
        'success'   => 'The :campaign campaign is now boosted. Enjoy all the new awesome features!',
        'title'     => 'Boost :campaign',
        'upgrade'   => 'upgrade your subscription',
    ],
    'campaign'  => [
        'boosted'       => 'Boosted by :user since :time',
        'premium'       => 'Premium features unlocked thanks to :user since :time',
        'standard'      => 'Standard',
        'superboosted'  => 'Superboosted by :user since :time',
        'unboosted'     => 'Unboosted',
    ],
    'intro'     => [
        'anyone'    => 'You aren\'t limited to only boosting campaigns you\'ve created. You can boost any campaign you are a part of or can see. This includes campaigns where you are a player, or :public you enjoy.',
        'data'      => 'When a campaign is no longer boosted, access to boosted features is removed. However, no content is deleted, so boosting the campaign again in the future restores access to it.',
        'first'     => 'Advanced features are unlocked by assigning your boosters to boost or superboost to a campaign. The amount of boosters you have is determined by your :subscription. This number is available to you at all time while you are a subscriber. Boosting a campaign will assign one of your boosters to it, while superboosting a campaign assigns three of them.',
    ],
    'pitch'     => [
        'benefits'      => [
            'backup'        => 'Recover a previously deleted entity for up to :amount days',
            'customisable'  => 'Full customisation of the look of a campaign',
            'entities'      => 'Better control over how entities behave and appear',
            'icons'         => 'Access to thousands of beautiful icons for maps and timelines',
            'relations'     => 'Explore an entity\'s relations visually in a visual explorer',
            'title'         => 'Boosted campaigns get',
            'upload'        => 'Bigger upload size for all campaign members',
        ],
        'description'   => 'Assign boosters to campaigns and help unlock amazing features for everyone involved. Not impressed by boosted campaigns? We\'ve got you covered with superboosted campaigns!',
        'more'          => 'Check out the full list of perks on our :boosters page.',
        'title'         => 'Take a campaign to the next level with customisation and perks for all of its members',
    ],
    'ready'     => [
        'available'         => 'Your available campaign boosters.',
        'pricing'           => 'All of our subscription levels include at least one campaign booster and start at :amount per month.',
        'pricing-amount'    => ':currency:amount',
        'title'             => 'Boost a campaign',
    ],
    'superboost'=> [
        'actions'   => [
            'confirm'   => 'Superboost it!',
            'instead'   => 'Superboost it for :count!',
            'remove'    => 'Stop superboosting :campaign',
        ],
        'confirm'   => 'How exciting! You\'re about to superboost :campaign. This will assign three (:cost) of your available campaign boosters.',
        'errors'    => [
            'boosted'   => 'Oh oh, looks like :campaign is already superboosted!',
        ],
        'success'   => 'The :campaign campaign is now superboosted. Enjoy all the new awesome features!',
        'title'     => 'Superboost :campaign',
        'upgrade'   => 'Ready for the ultimate Kanka experience? Superboosting :campaign will assign :cost additional campaign boosters.',
    ],
    'title'     => 'Campaign Boosters',
    'unboost'   => [
        'confirm'   => 'Yes, I\'m sure',
        'status'    => [
            'boosting'      => 'boosting',
            'superboosting' => 'superboosting',
        ],
        'success'   => 'The :campaign campaign is no longer boosted, and your boosters are available again.',
        'title'     => 'Unboosting a campaign',
        'warning'   => 'Are you sure you want to stop :action :campaign? This will release your assigned boosters, and hide all content and features related to the perks until the campaign is boosted again.',
    ],
];
