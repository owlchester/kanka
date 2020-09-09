<?php

return [
    'campaign'          => [
        'boost'         => [
            'add'           => 'Campaign :campaign is being boosted by :user.',
            'remove'        => ':user is no longer boosting the :campaign campaign.',
            'superboost'    => 'Campaign :campaign is being superboosted by :user.',
        ],
        'export'        => 'An export of a campaign is available. You can download it by clicking <a href=":link">here</a>. The link is available for :time minutes.',
        'export_error'  => 'An error occurred while exporting your campaign. Please contact us if this problem persists.',
        'join'          => ':user joined the campaign :campaign.',
        'leave'         => ':user left the campaign :campaign.',
        'role'          => [
            'add'       => 'You have been added to the :role role in the :campaign campaign.',
            'remove'    => 'You have been removed from the :role role in the :campaign campaign.',
        ],
    ],
    'header'            => 'You have :count notifications',
    'index'             => [
        'description'   => 'Your latest notifications.',
        'title'         => 'Notifications',
    ],
    'no_notifications'  => 'There are currently no notifications.',
    'permissions'       => [
        'body'  => 'Hey, we want to let you know that we\'ve completely changed the permissions system for each campaign!</p><p>Campaigns can now have roles, and each role can have permissions to access, edit or delete entities. Each entity can also be fine-tuned with user-specific permissions, meaning Becky and Alfred can edit their own characters!</p><p>The only downside is that campaigns with several users will have to set their new permissions. If you are the Admin of a campaign, you can do that in the campaign management page. If you are part of a campaign, you won\'t see anything until a campaign admin has taken care of it.',
        'title' => 'Permission Changes',
    ],
    'subscriptions'     => [
        'charge_fail'   => 'An error occurred while processing your payment. Please wait a moment while we try again. If nothing changes, please contact us.',
        'deleted'       => 'Your subscription to Kanka was cancelled after too many failed attempts to charge your card. Please go to your Subscription settings and try updating your payment details.',
        'ended'         => 'Your subscription to Kanka has ended. Your campaign boosts and Discord roles have been removed. We hope to see you back soon!',
        'failed'        => 'We couldn\'t charge your payment details. Please update them in your Payment Method settings.',
        'started'       => 'Your subscription to Kanka has started.',
    ],
];
