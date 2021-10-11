<?php

return [
    'campaign'          => [
        'application'   => [
            'approved'  => 'Your application to the :campaign campaign has been approved.',
            'new'       => 'New application for :campaign.',
            'rejected'  => 'Your application to the :campaign campaign has been rejected. Reason provided: :reason',
        ],
        'asset_export'  => 'An export of a campaign assets is available. The link is available for :time minutes.',
        'boost'         => [
            'add'           => 'Campaign :campaign is being boosted by :user.',
            'remove'        => ':user is no longer boosting the :campaign campaign.',
            'superboost'    => 'Campaign :campaign is being superboosted by :user.',
        ],
        'export'        => 'An export of a campaign is available. The link is available for :time minutes.',
        'export_error'  => 'An error occurred while exporting your campaign assets. Please contact us if this problem persists. This happens on bigger campaigns with many big images.',
        'join'          => ':user joined the campaign :campaign.',
        'leave'         => ':user left the campaign :campaign.',
        'plugin'        => [
            'deleted'   => 'The plugin :plugin was deleted from the marketplace and removed from your campaign :campaign.',
        ],
        'role'          => [
            'add'       => 'You have been added to the :role role in the :campaign campaign.',
            'remove'    => 'You have been removed from the :role role in the :campaign campaign.',
        ],
    ],
    'clear'             => [
        'action'    => 'Clear all',
        'confirm'   => 'Are you sure you want to remove all notifications? This action can\'t be undone.',
        'success'   => 'Notifications removed.',
    ],
    'header'            => 'You have :count notifications',
    'index'             => [
        'title' => 'Notifications',
    ],
    'no_notifications'  => 'Notifications will appear here once you have some.',
    'subscriptions'     => [
        'charge_fail'   => 'An error occurred while processing your payment. Please wait a moment while we try again. If nothing changes, please contact us.',
        'deleted'       => 'Your subscription to Kanka was cancelled after too many failed attempts to charge your card. Please go to your Subscription settings and try updating your payment details.',
        'ended'         => 'Your subscription to Kanka has ended. Your campaign boosts and Discord roles have been removed. We hope to see you back soon!',
        'failed'        => 'We couldn\'t charge your payment details. Please update them in your Payment Method settings.',
        'started'       => 'Your subscription to Kanka has started.',
    ],
    'unread'            => 'New notification',
];
